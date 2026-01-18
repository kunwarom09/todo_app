<?php

namespace App\Controller;

trait RenderTrait
{
    protected function render(string $template, array $data = []): string
    {
        $base = explode("\\",
            str_replace(
                "controller", "",
                strtolower(__CLASS__)
            )
        );
        $base = array_pop($base);
        return $this->templateEngine->render("/{$base}/{$template}", $data);
    }
}