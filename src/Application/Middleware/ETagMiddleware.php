<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Stream;

class ETagMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        // Call the next middleware in the stack
        $response = $next($request, $response);

        // Check if the response has a body
        $body = $response->getBody();
        if ($body->isSeekable()) {
            // Calculate the ETag based on the content of the response body
            $etag = md5($body->getContents());
            
            // Check if the client provided an If-None-Match header
            $clientEtag = $request->getHeaderLine('If-None-Match');
            
            // Compare the client's ETag with the calculated ETag
            if ($etag === $clientEtag) {
                // If they match, return a 304 Not Modified response
                return $response->withStatus(304);
            }
            
            // Set the calculated ETag in the response header
            $response = $response->withHeader('ETag', $etag);
        }

        return $response;

////////////// If-Match 
        // // Call the next middleware in the stack
        // $response = $next($request, $response);

        // // Check if the response has a body
        // $body = $response->getBody();
        // if ($body->isSeekable()) {
        //     // Calculate the ETag based on the content of the response body
        //     $etag = md5($body->getContents());
            
        //     // Check if the client provided an If-None-Match header
        //     $clientEtag = $request->getHeaderLine('If-None-Match');
            
        //     // Check if the client provided an If-Match header
        //     $ifMatch = $request->getHeaderLine('If-Match');
            
        //     if (!empty($ifMatch)) {
        //         // If the client provided an If-Match header, compare it with the calculated ETag
        //         if ($etag !== $ifMatch) {
        //             // If they don't match, return a 412 Precondition Failed response
        //             return $response->withStatus(412);
        //         }
        //     } elseif ($etag === $clientEtag) {
        //         // If the client provided an If-None-Match header and the ETags match, return a 304 Not Modified response
        //         return $response->withStatus(304);
        //     }
            
        //     // Set the calculated ETag in the response header
        //     $response = $response->withHeader('ETag', $etag);
        // }

        // return $response;

        //////If-Modified-Since
        // // Call the next middleware in the stack
        // $response = $next($request, $response);

        // // Check if the response has a body
        // $body = $response->getBody();
        // if ($body->isSeekable()) {
        //     // Calculate the ETag based on the content of the response body
        //     $etag = md5($body->getContents());
            
        //     // Check if the client provided an If-None-Match header
        //     $clientEtag = $request->getHeaderLine('If-None-Match');
            
        //     // Check if the client provided an If-Match header
        //     $ifMatch = $request->getHeaderLine('If-Match');
            
        //     // Check if the client provided an If-Modified-Since header
        //     $ifModifiedSince = $request->getHeaderLine('If-Modified-Since');
            
        //     if (!empty($ifMatch)) {
        //         // If the client provided an If-Match header, compare it with the calculated ETag
        //         if ($etag !== $ifMatch) {
        //             // If they don't match, return a 412 Precondition Failed response
        //             return $response->withStatus(412);
        //         }
        //     } elseif ($etag === $clientEtag) {
        //         // If the client provided an If-None-Match header and the ETags match, return a 304 Not Modified response
        //         return $response->withStatus(304);
        //     }

        //     // Parse the If-Modified-Since header into a timestamp
        //     $ifModifiedSinceTimestamp = strtotime($ifModifiedSince);
            
        //     if (!empty($ifModifiedSinceTimestamp)) {
        //         // Get the last modification timestamp of the response
        //         $lastModifiedTimestamp = $response->getHeaderLine('Last-Modified');
        //         $lastModifiedTimestamp = strtotime($lastModifiedTimestamp);
                
        //         // Compare the If-Modified-Since timestamp with the last modification timestamp
        //         if ($lastModifiedTimestamp > $ifModifiedSinceTimestamp) {
        //             // If the resource is modified since the If-Modified-Since timestamp, return a 200 OK response
        //             return $response;
        //         } else {
        //             // If not modified, return a 304 Not Modified response
        //             return $response->withStatus(304);
        //         }
        //     }
            
        //     // Set the calculated ETag in the response header
        //     $response = $response->withHeader('ETag', $etag);
        // }

        // return $response;

        ////Keep-Alive: timeout=5, max=1000
    }
}
