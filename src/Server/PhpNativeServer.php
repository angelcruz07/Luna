<?php

namespace Lune\Server;

use Lune\Http\HttpMethod;
use Lune\Http\Response;

/**
 * Represents a PHP native server implementation of the Server interface.
 */
class PhpNativeServer implements Server
{
    /**
     * Retrieves the request URI from the $_SERVER superglobal.
     *
     * @return string The request URI.
     */
    public function requestUri(): string
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Retrieves the request method from the $_SERVER superglobal and converts it to an HttpMethod object.
     *
     * @return HttpMethod The request method.
     */
    public function requestMethod(): HttpMethod
    {
        return HttpMethod::from($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * Retrieves the POST data from the $_POST superglobal.
     *
     * @return array The POST data.
     */
    public function postData(): array
    {
        return $_POST;
    }

    /**
     * Retrieves the query parameters from the $_GET superglobal.
     *
     * @return array The query parameters.
     */
    public function queryParams(): array
    {
        return $_GET;
    }

    /**
     * Sends the response to the client.
     *
     * @param Response $response The response object to send.
     * @return void
     */
    public function sendResponse(Response $response)
    {
        /* Php sends a default Content-Type header, but it has to be removed
          if the response has not content. Content-Type header can't be removed
          unless it is set to some value before.
        */
        header('Content-Type: None');
        header_remove('Content-Type');

        $response->prepare();
        http_response_code($response -> status());
        foreach ($response -> headers() as $header => $value) {
            header("$header: $value");
        }
        print($response -> content());
    }
}
