<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RajaOngkirService
{
    public function calculate(string $destination, int $weight, string $courier): array
    {
        $key = config('services.rajaongkir.key') ?? config('services.komship.key');
        if (!$key) {
            throw new RuntimeException('API key RajaOngkir belum dikonfigurasi.');
        }

        $endpoint = config('services.rajaongkir.cost_endpoint') ?? config('services.komship.cost_endpoint');
        if (!$endpoint) {
            throw new RuntimeException('Endpoint cek ongkir RajaOngkir belum dikonfigurasi.');
        }

        $origin = config('services.rajaongkir.origin') ?? config('services.komship.origin');

        $response = Http::withHeaders(['key' => $key, 'Accept' => 'application/json'])
            ->asJson()
            ->timeout(15)
            ->post($endpoint, [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(data_get($response->json(), 'rajaongkir.status.message', data_get($response->json(), 'message', 'RajaOngkir gagal mengembalikan tarif ongkir.')));
        }

        $payload = $response->json();
        $results = data_get($payload, 'rajaongkir.results', data_get($payload, 'results', data_get($payload, 'data', [])));

        if (!is_array($results)) {
            return [];
        }

        return collect($results)
            ->flatMap(function ($courierResult) {
                $courierCosts = data_get($courierResult, 'costs', []);

                return collect($courierCosts)->map(function ($service) use ($courierResult) {
                    $cost = data_get($service, 'cost.0', []);

                    return [
                        'service' => data_get($service, 'service', data_get($courierResult, 'code', '-')),
                        'description' => data_get($service, 'description', ''),
                        'value' => (int) data_get($cost, 'value', data_get($service, 'price', 0)),
                        'etd' => data_get($cost, 'etd', data_get($cost, 'estimate', '-')),
                        'note' => data_get($cost, 'note', ''),
                    ];
                })->values();
            })
            ->values()
            ->all();
    }
}
