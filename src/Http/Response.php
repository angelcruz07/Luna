<?php

namespace Lune\Http;

class Response {
    protected int $statusCode = 200;
    protected array $headers = [];
    protected ?string $content = null;
    

    public function status():int {
        return $this -> statusCode;
    }

    public function setStatus(int $statusCode): void {
        $this -> statusCode = $statusCode;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function setHeader( string $header, string $value) {
        $this -> headers[strtolower($header)] = $value;
    }

    public function removeHeader(string $header) {
        unset($this -> headers[strtolower($header)]);
    }

    public function content(): ?string {
        return $this -> content;
    }

    public function setContent(string $content): void {
        $this -> content = $content;
    }

    public function prepare(){
        if(is_null($this -> content)){
            $this -> removeHeader('Content-Type');
            $this -> removeHeader('Content-Length');
        }else {
            $this->setHeader('Content-Length', (string) strlen($this -> content));
        }
    }

}
