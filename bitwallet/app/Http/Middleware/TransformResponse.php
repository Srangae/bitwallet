<?php

namespace App\Http\Middleware;

use Closure;

class TransformResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response =  $next($request);
        return $this->transform($response);

    }

    private function transform($response)
    {
        return response()->json(
            [
                'error' => false,
                'data' => json_decode($response->getContent())
            ]
        );
    }
}
