<?php

namespace App\Console\Commands;

use App\Models\House;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver; // Updated to Imagick Driver
use Intervention\Image\Format;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:convert-webp
        {--quality=80 : WebP quality (1-100)}
        {--keep-original : Keep the original file instead of deleting it}
        {--dry-run : Show what would happen without changing anything}';

    protected ImageManager $manager;

    protected $description = 'Convert existing house unit images to WebP in-place and update stored JSON paths';

    public function handle()
    {
        $quality = (int) $this->option('quality');
        $keepOriginal = $this->option('keep-original');
        $dryRun = $this->option('dry-run');

        // Switch to Imagick driver
        $this->manager = ImageManager::usingDriver(Driver::class);

        $houses = House::all();
        $bar = $this->output->createProgressBar($houses->count());
        $converted = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($houses as $house) {
            $units = $house->units ?? [];
            $houseChanged = false;

            foreach ($units as $unitIndex => $unit) {
                if (empty($unit['images'])) {
                    continue;
                }

                foreach ($unit['images'] as $imgIndex => $img) {
                    // Already webp, nothing to do
                    if (str_ends_with(strtolower($img), '.webp')) {
                        $skipped++;
                        continue;
                    }

                    $sourcePath = Storage::disk('public')->path($img);

                    if (!file_exists($sourcePath)) {
                        $this->newLine();
                        $this->warn("Missing source file: {$img}");
                        $failed++;
                        continue;
                    }

                    // Same folder, same name, new extension
                    // e.g. units/abc123.jpg -> units/abc123.webp
                    $newRelativePath = preg_replace('/\.[^.]+$/', '.webp', $img);
                    $newFullPath = Storage::disk('public')->path($newRelativePath);

                    if ($dryRun) {
                        $this->newLine();
                        $this->line("Would convert: {$img} -> {$newRelativePath}");
                        $bar->advance(0);
                        continue;
                    }

                    try {
                        $webp = $this->manager
                            ->decodePath($sourcePath)
                            ->encodeUsingFormat(Format::WEBP, quality: $quality);
                        Storage::disk('public')->put($newRelativePath, (string) $webp);

                        // Update the path in the in-memory array
                        $units[$unitIndex]['images'][$imgIndex] = $newRelativePath;
                        $houseChanged = true;

                        if (!$keepOriginal) {
                            Storage::disk('public')->delete($img);
                        }

                        $converted++;
                    } catch (\Throwable $e) {
                        $this->newLine();
                        $this->error("Failed on {$img}: " . $e->getMessage());
                        $failed++;
                    }
                }
            }

            if ($houseChanged && !$dryRun) {
                $house->units = $units;
                $house->save();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("Dry run complete. Nothing was changed.");
        } else {
            $this->info("Done. Converted: {$converted}, Skipped (already webp): {$skipped}, Failed: {$failed}");
        }
    }
}