<?php

namespace Tests\Feature;

use App\Http\Middleware\ProductionSecurityMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductionSecurityTest extends TestCase
{
    public function test_localhost_requests_are_not_redirected_to_https_in_production(): void
    {
        config()->set('app.env', 'production');

        $request = Request::create('http://127.0.0.1:8000/admin/dashboard', 'GET');

        $response = (new ProductionSecurityMiddleware)->handle($request, function ($request) {
            return response('ok');
        });

        $this->assertSame(200, $response->getStatusCode());
        $this->assertFalse($response->headers->has('Location'));
    }
}
