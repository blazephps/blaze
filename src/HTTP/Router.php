<?php

namespace BlazePHP\Blaze\HTTP;

use Closure;

class Router
{
    protected array $handlers;
    protected mixed $notFoundHandler;

    public function run(): void
    {
        $requestUri = parse_url($_SERVER["REQUEST_URI"]);
        $requestPath = $requestUri["path"];
        $method = $_SERVER["REQUEST_METHOD"];

        $callback = null;
        $param = [];
        foreach ($this->handlers as $handler) {
            if (preg_match("%^{$handler['path']}$%", $requestPath, $matches) === 1 && $handler["method"] === $method) {
                $callback = $handler["handler"];
                unset($matches[0]);
                $param = $matches;
                break;
            }
        }

        if (!$callback) {
            if(!$this->notFoundHandler) {
                header("HTTP/1.0 404 Not Found");
            } else {
                echo call_user_func($this->notFoundHandler);
            }
            return;
        } elseif (is_array($callback)) {
            $instance = new $callback[0];
            $instance->{$callback[1]}(new Request($_GET, $_POST), ...$param);
        }

        echo call_user_func_array($callback, [
            new Request($_GET, $_POST),
            ...$param
        ]);
    }


    /**
     * All router method types `GET`
     *
     * @param string $path
     * @param $handler
     *
     * @return void
     */
    public function get(string $path, $handler): void
    {
        $path = preg_replace("/{.+}/", "(.+)", $path);
        $this->handlers['GET' . $path] = [
            'path' => $path,
            'method' => 'GET',
            'handler' => $handler
        ];
    }

    /**
     * All router method types `POST`
     *
     * @param string $path
     * @param $handler
     *
     * @return void
     */
    public function post(string $path, $handler): void
    {
        $path = preg_replace("/{.+}/", "(.+)", $path);
        $this->handlers['POST' . $path] = [
            'path' => $path,
            'method' => 'POST',
            'handler' => $handler
        ];
    }

    /**
     * All router method types `DELETE`
     *
     * @param string $path
     * @param $handler
     *
     * @return void
     */
    public function delete(string $path, $handler): void
    {
        $path = preg_replace("/{.+}/", "(.+)", $path);
        $this->handlers['DELETE' . $path] = [
            'path' => $path,
            'method' => 'DELETE',
            'handler' => $handler
        ];
    }

    /**
     * All router method types `HEAD`
     *
     * @param string $path
     * @param $handler
     *
     * @return void
     */
    public function head(string $path, $handler): void
    {
        $path = preg_replace("/{.+}/", "(.+)", $path);
        $this->handlers['HEAD' . $path] = [
            'path' => $path,
            'method' => 'HEAD',
            'handler' => $handler
        ];
    }

    /**
     * Used when the users visit undefined / 404 page
     *
     * @param Closure $handler
     * @return void
     */
    public function addNotFoundHandler(Closure $handler): void
    {
        $this->notFoundHandler = $handler;
    }
}