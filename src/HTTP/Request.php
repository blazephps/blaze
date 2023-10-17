<?php

namespace BlazePHP\Blaze\HTTP;

class Request
{
    protected array $get;
    protected array $post;

    public function __construct(array $get, array $post)
    {
        $this->get = $get;
        $this->post = $post;
    }

    /**
     * Returns array in $this->get variables
     *
     * @return array
     */
    public function get(): array
    {
        return $this->get;
    }

    /**
     * Returns array in $this->post variables
     *
     * @return array
     */
    public function post(): array
    {
        return $this->post;
    }

    /**
     * Redirect user to set URL
     *
     * @param string $path
     * @return void
     */
    public function redirect(string $path): void
    {
        header("Location: $path", true);
    }

    /**
     * 200 is OK
     * 404 is Not Found
     * 403 is Forbidden
     * for more read https://www.php.net/manual/en/function.http-response-code.php
     *
     * @param int $code
     * @return void
     */
    public function code(int $code = 200): void
    {
        http_response_code($code);
    }
}