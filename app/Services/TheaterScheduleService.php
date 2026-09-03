<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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
     *
     * @return array<int, array<string, mixed>>
     */
    public function getDelynnSchedule(): array
    {
        /** @var array<int, array<string, mixed>> */
        return Cache::remember('delynn_theater_schedule', 300, function (): array {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/api/v1/theater", [
                'page' => 1,
            ]);

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json('data');
            if (! is_array($data)) {
                return [];
            }

            return array_values(array_filter($data, function (mixed $show): bool {
                if (! is_array($show)) {
                    return false;
                }

                $lineup = $show['lineup'] ?? [];
                if (! is_array($lineup)) {
                    return false;
                }

                foreach ($lineup as $member) {
                    if (is_array($member) && ($member['name'] ?? null) === 'Delynn') {
                        return true;
                    }
                }

                return false;
            }));
        });
    }
}
