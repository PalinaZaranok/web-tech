<?php

class TemplateFacade
{
    public function render($templatePath, $data = [])
    {
        $template = file_get_contents($templatePath);

        foreach ($data as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $template = str_replace($placeholder, this->escape($value), $template);
        }

        return $template;
    }
}