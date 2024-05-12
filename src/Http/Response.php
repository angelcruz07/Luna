<?php

namespace Lune\Http;

class Response {
    protected int $statusCode = 200;
    protected array $headers = [];
    protected ?string $content = null;
    

    public function status():int {
        return $this -> statusCode;
    }

    public function setStatus(int $statusCode): self {
        $this -> statusCode = $statusCode;
        return $this;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function setHeader( string $header, string $value): self {
        $this -> headers[strtolower($header)] = $value;
        return $this;
    }

    public function removeHeader(string $header) {
        unset($this -> headers[strtolower($header)]);
    }
    public function setContentType(string $value): self{
        $this -> setHeader('Content-Type', $value);
        return $this;
    }

    public function content(): ?string {
        return $this -> content;
    }

    public function setContent(string $content): self {
        $this -> content = $content;
        return $this;
    }

    public function prepare(){
        if(is_null($this -> content)){
            $this -> removeHeader('Content-Type');
            $this -> removeHeader('Content-Length');
        }else {
            $this->setHeader('Content-Length', (string) strlen($this -> content));
        }
    }

    // Factory methods
    public static function json(array $data): self {
        return  (new self())
        ->setContentType('application/json')
        ->setContent(json_encode($data));
    }

    public static function text(string $text): self {
        return  (new self())
        ->setContentType('text/plain')
        ->setContent($text);
    }

    public static function redirect(string $uri):self{
        return (new self())
        ->setStatus(302)
        ->setHeader('Location', $uri);
    }
}
