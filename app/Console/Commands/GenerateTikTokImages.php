<?php

namespace App\Console\Commands;

use App\Models\House;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class GenerateTikTokImages extends Command
{
    protected $signature = 'tiktok:generate-images {--house_id= : Process a single house ID}';
    protected $description = 'Generate TikTok-compliant (<=1080p baseline JPEG) image derivatives from house units';

    protected ImageManager $manager;

    public function handle(): int
    {
        $houseId = $this->option('house_id');
        $query = House::query();

        if ($houseId) {
            $query->where('id', $houseId);
        }

        $houses = $query->get();

        if ($houses->isEmpty()) {
            $this->warn('No house records found.');
            return self::SUCCESS;
        }

        // Initialize Intervention Manager v3 with Imagick Driver
        $this->manager = ImageManager::usingDriver(Driver::class);

        foreach ($houses as $house) {
            $this->info("Processing House ID: {$house->id}");

            $units = $house->units ?? [];

            if (empty($units)) {
                $this->warn("  No units JSON found for House ID {$house->id}");
                continue;
            }

            $updatedUnits = [];

            foreach ($units as $unit) {
                $images = $unit['images'] ?? [];
                $virtualTourImages = $unit['virtual_tour_images'] ?? [];
                $allPaths = array_unique(array_filter(array_merge($images, $virtualTourImages)));

                $tiktokPaths = [];

                foreach ($allPaths as $path) {
                    $originalFullPath = Storage::disk('public')->path($path);

                    if (!file_exists($originalFullPath)) {
                        $this->error("  [NOT FOUND] File missing: {$originalFullPath}");
                        continue;
                    }

                    // Force target extension to .jpg (converting WebP -> baseline JPEG)
                    $pathInfo = pathinfo($path);
                    $filename = $pathInfo['filename'] . '.jpg';
                    $tiktokRelativePath = 'tiktok/' . $pathInfo['dirname'] . '/' . $filename;
                    
                    // Ensure target directory exists
                    Storage::disk('public')->makeDirectory('tiktok/' . $pathInfo['dirname']);

                    try {
                        // 1. Decode path (Intervention v3 method)
                        $image = $this->manager->decodePath($originalFullPath);

                        // 2. Scale down if dimension > 1080px (Intervention v3 method)
                        $image->scaleDown(width: 1080, height: 1080);

                        // 3. Encode to JPEG format with quality 85
                        $jpegData = $image->encodeUsingFormat(Format::JPEG, quality: 85);

                        // 4. Save to public disk
                        Storage::disk('public')->put($tiktokRelativePath, (string) $jpegData);

                        $tiktokPaths[] = $tiktokRelativePath;
                        $this->line("  [OK] Converted {$pathInfo['basename']} -> {$tiktokRelativePath}");
                    } catch (\Throwable $e) {
                        $this->error("  [FAILED] Could not convert {$path}: {$e->getMessage()}");
                    }
                }

                // Append tiktok_images array to this unit
                $unit['tiktok_images'] = array_values($tiktokPaths);
                $updatedUnits[] = $unit;
            }

            // Save updated units JSON to House model
            $house->units = $updatedUnits;
            $house->save();

            $this->info("  Saved updated units JSON for House ID {$house->id}");
        }

        $this->info('TikTok image generation complete!');
        return self::SUCCESS;
    }
}