<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;

class SupabaseStorageService
{
    protected string $url;
    protected string $key;
    protected string $bucket;

    public function __construct()
    {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
        $this->bucket = config('services.supabase.bucket');
    }

    public function upload(UploadedFile $file): array
    {
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
            'apikey' => $this->key,
            'Content-Type' => $file->getMimeType(),
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post("{$this->url}/storage/v1/object/{$this->bucket}/{$filename}");

        $publicUrl = "{$this->url}/storage/v1/object/public/{$this->bucket}/{$filename}";

        return [
            'url' => $publicUrl,
            'path' => $filename,
        ];
    }

    public function delete(string $path): void
    {
        Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
            'apikey' => $this->key,
        ])->delete("{$this->url}/storage/v1/object/{$this->bucket}/{$path}");
    }
}