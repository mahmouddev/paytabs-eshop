<?php

namespace App\Middleware;

use Cake\Cache\Cache;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RateLimitMiddleware implements MiddlewareInterface
{
    private $rateLimit = 360; // Maximum requests
    private $timeWindow = 3600; // Time window in seconds (1 hour)

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        // Get client IP
        $clientIp = $request->getServerParams()['REMOTE_ADDR'];

        // Define cache key
        $cacheKey = 'rate_limit_' . $clientIp;

        // Get current request count from cache
        $rateData = Cache::read($cacheKey, 'default') ?? ['count' => 0, 'expires' => time() + $this->timeWindow];

        // Reset rate data if the time window has expired
        if (time() > $rateData['expires']) {
            $rateData = ['count' => 0, 'expires' => time() + $this->timeWindow];
        }

        // Increment request count
        $rateData['count']++;

        // Save updated rate data back to cache
        Cache::write($cacheKey, $rateData, 'default');

        // Check if rate limit is exceeded
        if ($rateData['count'] > $this->rateLimit) {
            return new Response([
                'statusCode' => 429,
                'type' => 'application/json',
                'body' => json_encode([
                    'message' => 'Rate limit exceeded. Try again later.'
                ]),
            ]);
        }

        // Proceed to the next middleware or request handler
        return $handler->handle($request);
    }
}
