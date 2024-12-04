<?php

namespace app\core;

class View
{
    public $template = 'default';

    public function __construct(string $template = null)
    {
        if ($template) {
            $this->template = $template;
        }
    }

    public function render(string $page, ?array $data = null): void
    {
        if ($data) {
            extract($data);
        }
        include_once TEMPLATES . $this->template . '.php';
    }
}
