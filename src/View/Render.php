<?php

namespace BlazePHP\Blaze\View;

class Render
{

    /**
     * Variables
     */
    protected array $sectionStack = [];
    protected array $sections = [];
    protected $currentSection;
    protected $layout;
    protected $dir;
    protected $name;

    public function new(string $name, array $options = array()): mixed
    {
        $this->name = str_replace(".php", "", $name);
        $this->dir = dirname(__DIR__, 2);

        $output = (function (): string{
            ob_start();
            include $this->dir . "/app/View/{$this->name}.php";

            return ob_get_clean() ?: '';
        })();

        foreach ($options as $key => $val) {
            $output = str_replace("{{" . $key . "}}", $val, $output);
            $output = str_replace("{{" . $key . " }}", $val, $output);
            $output = str_replace("{{ " . $key . "}}", $val, $output);
            $output = str_replace("{{ " . $key . " }}", $val, $output);
        }

        if ($this->layout !== null && $this->sectionStack === []) {
            $layoutView = $this->layout;
            $this->layout = null;
            $output = $this->new($layoutView, $options);
        }

        echo $output;
        return "";
    }

    public function html(string $html): string
    {
        return htmlspecialchars($html);
    }

    public function include(string $file): void
    {
        $this->new($this->dir, (array)$file);
    }

    public function extends (string $layout): void
    {
        $this->layout = $layout;
    }

    public function section(string $name): void
    {
        $this->currentSection = $name;
        $this->sectionStack[] = $name;

        ob_start();
    }

    public function endSection(): void
    {
        $contents = ob_get_clean();

        if ($this->sectionStack === []) {
            throw new \RuntimeException('View themes, no current section.');
        }

        $section = array_pop($this->sectionStack);

        if (!array_key_exists($section, $this->sections)) {
            $this->sections[$section] = [];
        }

        $this->sections[$section][] = $contents;
    }

    public function yield(string $sectionName): void
    {
        if (!isset($this->sections[$sectionName])) {
            echo '';

            return;
        }

        foreach ($this->sections[$sectionName] as $key => $contents) {
            echo $contents;
            unset($this->sections[$sectionName][$key]);
        }
    }
}