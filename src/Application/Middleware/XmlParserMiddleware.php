<?php

    namespace App\Middleware;

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    class XmlParserMiddleware
    {
        // public function __invoke(Request $request, Response $response, $next)
        // {

        //     $response = $next($request, $response);

        //     if ($response->getBody() instanceof \SimpleXMLElement) {
        //         $response = $response->withHeader('Content-Type', 'application/xml');
        //     }

        //     return $response;
        // }

        public function __invoke(Request $request, RequestHandler $handler): Response
        {
            $xmlString = '<data><item>Item 1</item><item>Item 2</item></data>';
            $xml = new \SimpleXMLElement($xmlString);

            $request = $request->withAttribute('parsed_xml', $xml);

            return $handler->handle($request);
        }
    }
