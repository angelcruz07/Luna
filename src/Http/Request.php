<?php

namespace Lune\Http;
use Lune\Server\Server;

/**
 * Represents an HTTP request.
 */
class Request
{
  /**
   * The URI of the request.
   *
   * @var string
   */
  protected string $uri;

  /**
   * The HTTP method of the request.
   *
   * @var HttpMethod
   */
  protected HttpMethod $method; 

  /**
   * The data of the request.
   *
   * @var array
   */
  protected array $data;

  /**
   * The query parameters of the request.
   *
   * @var array
   */
  protected array $query;

  /**
   * Creates a new Request instance.
   *
   * @param Server $server The server object.
   */
  public function __construct(Server $server)
  {
    $this->uri = $server->requestUri();
    $this->method = $server->requestMethod();
    $this->data = $server->postData();
    $this->query = $server->queryParams();
  }

  /**
   * Gets the URI of the request.
   *
   * @return string The URI.
   */
  public function uri(): string {
    return $this->uri;
  }

  /**
   * Gets the HTTP method of the request.
   *
   * @return HttpMethod The HTTP method.
   */
  public function method(): HttpMethod { 
    return $this->method;
  }

  /**
   * Get the data from the request.
   *
   * @return array The data from the request.
   */
  public function data(): array {
    return $this->data;
  }

  /**
   * Get the query parameters from the request.
   *
   * @return array The query parameters from the request.
   */
  public function query(): array {
    return $this->query;
  }
}

?>