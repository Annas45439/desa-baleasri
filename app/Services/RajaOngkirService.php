<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RajaOngkirService
{
    public function calculate(string $destination, int $weight, string $courier): array
    {
        $key = config('services.komship.key');
        if (!$key) {
            throw new RuntimeException('API key Komship Shipping Delivery belum dikonfigurasi.');
        }
        if (!config('services.komship.cost_endpoint')) {
            throw new RuntimeException('Endpoint cek ongkir Komship belum dikonfigurasi.');
        }

        $response = Http::withHeaders(['x-api-key' => $key, 'Accept' => 'application/json'])
            ->asJson()
            ->timeout(15)
            ->post(config('services.komship.cost_endpoint'), [
                'origin' => config('services.komship.origin'),
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(data_get($response->json(), 'message', 'Komship gagal mengembalikan tarif ongkir.'));
        }

        $costs = data_get($response->json(), 'data', data_get($response->json(), 'results', []));
        return collect($costs)->map(function (array $service): array {
            $cost = $service['cost'][0] ?? $service;
            return [
                'service' => $service['service'] ?? $service['code'] ?? $service['courier'] ?? '-',
                'description' => $service['description'] ?? '',
                'value' => (int) ($cost['value'] ?? $cost['price'] ?? $cost['cost'] ?? 0),
                'etd' => $cost['etd'] ?? $cost['estimate'] ?? '-',
                'note' => $cost['note'] ?? '',
            ];
        })->values()->all();
    }
}
