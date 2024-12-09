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

    /**
     * Renders a view template.
     *
     * Extracts provided data into variables and includes the specified template.
     * Terminates script execution after rendering.
     *
     * @param string $page The name of the page or view to render.
     * @param array|null $data An associative array of data to pass to the view (optional).
     */
    public function render(string $page, ?array $data = null): void
    {
        if ($data) {
            extract($data);
        }
        include_once TEMPLATES . $this->template . '.php';
        exit();
    }

    /* Renders an error message and stops execution
     * @param string $message
     * @return never
     */
    public function renderError(array $data): never
    {
        extract($data);
        $page = 'errors';
        http_response_code($code);
        include_once TEMPLATES . $this->template . '.php';
        exit();
    }
}
