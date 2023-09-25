<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class UserDetailsMiddleware
{
    private $userDetails;

    public function __construct($userDetails)
    {
        $this->userDetails = $userDetails;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        
        $request = $request->withAttribute('user_details', $this->userDetails);

        return $handler->handle($request);
    }
}
