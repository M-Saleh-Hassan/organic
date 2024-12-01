<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;
use App\Models\MediaImage;
use App\Models\MediaVideo;

class MediaSeeder extends Seeder
{
    public function run()
    {
        for ($j = 1; $j <= 10; $j++) {
            $media = Media::create([
                'user_id' => $j % 3 + 1, // Rotate users 1, 2, 3
                'land_id' => $j, // Use the first 10 lands
            ]);

            // Add Images
            for ($i = 0; $i < 3; $i++) {
                MediaImage::create([
                    'media_id' => $media->id,
                    'file_path' => 'media/sample_image.jpg',
                    'date' => now()->subDays($i + 1),
                ]);
            }

            // Add Videos
            for ($i = 0; $i < 3; $i++) {
                MediaVideo::create([
                    'media_id' => $media->id,
                    'file_path' => 'media/sample_video.mp4',
                    'date' => now()->subDays($i + 1),
                ]);
            }
        }
    }
}
