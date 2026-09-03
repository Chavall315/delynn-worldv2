<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TheaterScheduleService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.jkt48connect.base_url');
        $this->apiKey = config('services.jkt48connect.api_key');
    }

    /**
     * Ambil jadwal theater yang ada Delynn di lineup-nya.
     * Di-cache 5 menit (samain sama cache TTL API-nya) biar hemat quota.
     */
    public function getDelynnSchedule(): array
    {
        return Cache::remember('delynn_theater_schedule', 300, function () {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/api/v1/theater", [
                'page' => 1,
            ]);

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json('data') ?? [];

            // Filter: cuma ambil show yang ada "Delynn" di lineup
            return collect($data)
                ->filter(function ($show) {
                    return collect($show['lineup'] ?? [])
                        ->contains(fn ($member) => $member['name'] === 'Delynn');
                })
                ->values()
                ->all();
        });
    }
}