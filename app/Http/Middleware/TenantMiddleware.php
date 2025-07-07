<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $cleanHost = preg_replace('/^www\./', '', $host);

        // If local environment, skip tenant DB switching
        if (in_array($cleanHost, ['localhost', '127.0.0.1'])) {
            return $next($request);
        }

        $tenant = Tenant::where('custom_domain', $cleanHost)
            ->orWhere('domain', $cleanHost)
            ->first();

        if (! $tenant) {
            abort(403, 'Shop not found.');
        }

        // Dynamically configure the tenant's DB connection
        Config::set('database.connections.tenant', [
            'driver' => 'mysql',
            'host' => env('DB_TENANT_HOST', '127.0.0.1'), // fallback to env or use a default
            'database' => $tenant->database_name,
            'username' => $tenant->database_username,
            'password' => $tenant->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Set default connection for this request
        DB::setDefaultConnection('tenant');

        // Optionally, share the tenant instance globally
        app()->instance('currentTenant', $tenant);

        return $next($request);
    }
}
