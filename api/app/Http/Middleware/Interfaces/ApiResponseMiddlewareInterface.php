<?php
declare(strict_types=1);

namespace App\Http\Middleware\Interfaces;

use Illuminate\Http\Request;

interface ApiResponseMiddlewareInterface
{
    /**
     * Handle incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next);
}

