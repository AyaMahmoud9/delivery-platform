<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

trait ImageUploadTrait
{
    protected function uploadProfileImage(UploadedFile $image): array
    {
        $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        $originalPath = 'profile-images/' . $fileName;
        $thumbnailPath = 'profile-images/thumbnails/' . $fileName;

        // Store original image
        $originalImage = Image::decode($image)
            ->encode();

        Storage::disk('public')->put(
            $originalPath,
            $originalImage
        );

        // Create thumbnail
        $thumbnail = Image::decode($image)
            ->cover(200, 200)
            ->encode();

        Storage::disk('public')->put(
            $thumbnailPath,
            $thumbnail
        );

        return [
            'profile_image' => $originalPath,
            'profile_thumbnail' => $thumbnailPath,
        ];
    }
}