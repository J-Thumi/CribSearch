<?php

namespace App\Observers;

use App\Models\House;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class HouseObserver
{
    /**
     * Handle the House "saved" event (covers created and updated).
     */
    public function saved(House $house): void
    {
        // Prevent infinite event loops when updating the model inside observer
        if ($house->isDirty('tiktok_images') && !$house->isDirty('units')) {
            return;
        }

        $units = $house->units ?? [];

        if (empty($units)) {
            return;
        }

        $manager = ImageManager::usingDriver(Driver::class);
        $updatedUnits = [];
        $allHouseTiktokPaths = [];

        foreach ($units as $unit) {
            $images = $unit['images'] ?? [];
            $virtualTourImages = $unit['virtual_tour_images'] ?? [];
            $allPaths = array_unique(array_filter(array_merge($images, $virtualTourImages)));

            $unitTiktokPaths = [];

            foreach ($allPaths as $path) {
                $originalFullPath = Storage::disk('public')->path($path);

                if (!file_exists($originalFullPath)) {
                    continue;
                }

                $pathInfo = pathinfo($path);
                $filename = $pathInfo['filename'] . '.jpg';
                $tiktokRelativePath = 'tiktok/' . $pathInfo['dirname'] . '/' . $filename;

                Storage::disk('public')->makeDirectory('tiktok/' . $pathInfo['dirname']);

                try {
                    // Decode image using Intervention v3
                    $image = $manager->decodePath($originalFullPath);

                    // Downscale to max 1080px box preserving aspect ratio
                    $image->scaleDown(width: 1080, height: 1080);

                    // Convert to baseline JPEG quality 85
                    $jpegData = $image->encodeUsingFormat(Format::JPEG, quality: 85);

                    Storage::disk('public')->put($tiktokRelativePath, (string) $jpegData);

                    $unitTiktokPaths[] = $tiktokRelativePath;
                    $allHouseTiktokPaths[] = $tiktokRelativePath;
                } catch (\Throwable $e) {
                    logger()->error("TikTok Image Generation failed for {$path}: " . $e->getMessage());
                }
            }

            // Nest tiktok_images directly inside the unit structure
            $unit['tiktok_images'] = array_values($unitTiktokPaths);
            $updatedUnits[] = $unit;
        }

        // Save silently without re-triggering model events
        $house->quietly(function () use ($house, $updatedUnits, $allHouseTiktokPaths) {
            $house->update([
                'units' => $updatedUnits,
                'tiktok_images' => array_values(array_unique($allHouseTiktokPaths)),
            ]);
        });
    }
}