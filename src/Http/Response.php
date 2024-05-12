<?php

namespace Lune\Http;

/**
 * Http response that will be sent to the client
 */
class Response {
    /**
     * Response HTTP status code
     *
     * @var integer
     */
    protected int $statusCode = 200;

    /**
     * Reponsse HTTP headers
     *
     * @var array <string, string>
     */
    protected array $headers = [];

    /**
     * Response content
     *
     * @var string|null
     */
    protected ?string $content = null;
    
    /**
     * Get the HTTP status code
     *
     * @return integer
     */
    public function status():int {
        return $this -> statusCode;
    }


    /**
     * Set the status code for the response.
     *
     * @param int $statusCode The HTTP status code to set.
     * @return self Returns the current instance of the Response class.
     */
    public function setStatus(int $statusCode): self {
        $this -> statusCode = $statusCode;
        return $this;
    }

    /**
     * Get the HTTP headers
     *
     * @return array<string, string>
     */
    public function headers(): array {
        return $this->headers;
    }


    /**
     * Sets a header value for the HTTP response.
     *
     * @param string $header The name of the header.
     * @param string $value The value of the header.
     * @return self Returns the current instance of the Response object.
     */
    public function setHeader( string $header, string $value): self {
        $this -> headers[strtolower($header)] = $value;
        return $this;
    }

    /**
     * Removes the specified header from the response.
     *
     * @param string $header The header to be removed.
     * @return void
     */
    public function removeHeader(string $header) {
        unset($this -> headers[strtolower($header)]);
    }

    /**
     * Sets the content type of the HTTP response.
     *
     * @param string $value The value of the content type.
     * @return self Returns the current instance of the Response class.
     */
    public function setContentType(string $value): self{
        $this -> setHeader('Content-Type', $value);
        return $this;
    }

    /**
     * Get the content of the response.
     *
     * @return string|null The content of the response.
     */
    public function content(): ?string {
        return $this->content;
    }

    /**
     * Set the content of the response.
     *
     * @param string $content The content to set.
     * @return self
     */
    public function setContent(string $content): self {
        $this -> content = $content;
        return $this;
    }

    /**
     * Prepares the HTTP response by setting the appropriate headers.
     * If the content is null, the 'Content-Type' and 'Content-Length' headers are removed.
     * If the content is not null, the 'Content-Length' header is set to the length of the content.
     */
    public function prepare(){
        if(is_null($this -> content)){
            $this -> removeHeader('Content-Type');
            $this -> removeHeader('Content-Length');
        }else {
            $this->setHeader('Content-Length', (string) strlen($this -> content));
        }
    }

    // Factory methods
    /**
     * Creates a JSON response.
     *
     * @param array $data The data to be encoded as JSON.
     * @return self The JSON response.
     */
    public static function json(array $data): self {
        return  (new self())
        ->setContentType('application/json')
        ->setContent(json_encode($data));
    }

    /**
     * Creates a text response.
     *
     * @param string $text The text content of the response.
     * @return self The text response.
     */
    public static function text(string $text): self {
        return  (new self())
        ->setContentType('text/plain')
        ->setContent($text);
    }

    /**
     * Creates a redirect response.
     *
     * @param string $uri The URI to redirect to.
     * @return self The redirect response.
     */
    public static function redirect(string $uri):self{
        return (new self())
        ->setStatus(302)
        ->setHeader('Location', $uri);
    }
}


?>