<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ⚠️ IMPORTANT pour Render : Accepter tous les proxies
        $middleware->trustProxies(at: '*');

        // Configuration des middlewares web (si vous en avez)
        $middleware->web(append: [
            // Vos middlewares web personnalisés
        ]);

        // Configuration des middlewares API (si vous en avez)
        $middleware->api(prepend: [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Alias de middlewares (optionnel)
        $middleware->alias([
            // 'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gestion personnalisée des exceptions
    })->create();