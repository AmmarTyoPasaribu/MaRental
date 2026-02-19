<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    /**
     * Upload file ke Cloudinary
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return array ['public_id' => ..., 'url' => ...]
     */
    public static function upload($file, $folder = 'rentalmobilmar')
    {
        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => $folder,
        ]);

        return [
            'public_id' => $result->getPublicId(),
            'url' => $result->getSecurePath(),
        ];
    }

    /**
     * Hapus file dari Cloudinary berdasarkan public_id
     *
     * @param string $publicId
     * @return void
     */
    public static function delete($publicId)
    {
        if ($publicId) {
            Cloudinary::destroy($publicId);
        }
    }
}
