<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

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

    /**
     * @return array{url: string, path: string}
     */
    public function upload(UploadedFile $file): array
    {
        $filename = uniqid().'_'.$file->getClientOriginalName();
        $realPath = $file->getRealPath();
        $content = $realPath ? file_get_contents($realPath) : false;

        if ($content === false) {
            throw new \RuntimeException('Failed to read uploaded file content.');
        }

        Http::withHeaders([
            'Authorization' => 'Bearer '.$this->key,
            'apikey' => $this->key,
            'Content-Type' => (string) $file->getMimeType(),
        ])->withBody(
            $content,
            (string) $file->getMimeType()
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
            'Authorization' => 'Bearer '.$this->key,
            'apikey' => $this->key,
        ])->delete("{$this->url}/storage/v1/object/{$this->bucket}/{$path}");
    }
}
