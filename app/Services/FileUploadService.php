<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    protected $disk = 'public';
    protected $path = 'uploads';
    protected $maxSize = 5242880; // 5MB

    public function storeImage(UploadedFile $file, $folder = 'images'): ?string
    {
        try {
            if ($file->getSize() > $this->maxSize) {
                throw new \Exception('File size exceeds maximum limit.');
            }

            $path = $file->store("{$this->path}/{$folder}", $this->disk);
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            return null;
        }
    }

    public function storeDocument(UploadedFile $file, $folder = 'documents'): ?string
    {
        try {
            if ($file->getSize() > $this->maxSize) {
                throw new \Exception('File size exceeds maximum limit.');
            }

            $path = $file->store("{$this->path}/{$folder}", $this->disk);
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('Document upload error: ' . $e->getMessage());
            return null;
        }
    }

    public function delete($path): bool
    {
        try {
            if ($path && Storage::disk($this->disk)->exists($path)) {
                Storage::disk($this->disk)->delete($path);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('File deletion error: ' . $e->getMessage());
            return false;
        }
    }

    public function getUrl($path): ?string
    {
        if (!$path) return null;
        return Storage::disk($this->disk)->url($path);
    }
}
