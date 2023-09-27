<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Middleware\ETagMiddleware;
return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/user',function (Request $request, Response $response) {
        $xml = $request->getAttribute('parsed_xml');

        $response->getBody()->write($xml->asXML());
        
        return $response
            ->withHeader('Content-Type', 'application/xml')
            ->withStatus(200);
    });

    $app->get('/userlist',function (Request $request, Response $response) {
        $userDetails = $request->getAttribute('user_details');

        $response->getBody()->write(json_encode($userDetails));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    });

    $app->get('/user', function (Request $request, Response $response) {
        $userData = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ];
    
        $response->getBody()->write(json_encode($userData));
    
        $response = $response->withHeader('Content-Type', 'application/json');
    
        return $response;
    })->add(new ETagMiddleware());
};
