<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use App\Middleware\XmlParserMiddleware;
return function (App $app) {
    $app->add(SessionMiddleware::class);
    
    $app = AppFactory::create();
    $app->add(new XmlParserMiddleware());

    $app->run();
};
