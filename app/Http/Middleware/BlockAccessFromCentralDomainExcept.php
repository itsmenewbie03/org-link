<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockAccessFromCentralDomainExcept
{
    /**
     * Set this property if you want to customize the on-fail behavior.
     *
     * @var callable|null
     */
    public static $abortRequest;

    public function handle(Request $request, Closure $next)
    {
        // HACK: we will allow if the request is /livewire/update
        if ($request->path() === 'livewire/update') {
            return $next($request);
        }

        if (in_array($request->getHost(), config('tenancy.central_domains'))) {
            $abortRequest = static::$abortRequest ?? function () {
                abort(404);
            };

            return $abortRequest($request, $next);
        }

        return $next($request);
    }
}
