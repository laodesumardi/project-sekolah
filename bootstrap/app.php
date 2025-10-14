<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'active' => \App\Http\Middleware\CheckActive::class,
            'student' => \App\Http\Middleware\CheckStudentRole::class,
            'teacher' => \App\Http\Middleware\CheckTeacherRole::class,
            'track.session' => \App\Http\Middleware\TrackLoginSession::class,
            'track.teacher.activity' => \App\Http\Middleware\TrackTeacherActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
