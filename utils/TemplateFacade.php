<?php

namespace utils;
class TemplateFacade
{
    public function render(string $templatePath, $data = [])
    {
        $template = file_get_contents($templatePath);

        foreach ($data as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $template = str_replace($placeholder, escape($value), $template);
        }
        return $template;
    }
}