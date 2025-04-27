<?php
declare(strict_types=1);
namespace utils;
require_once __UTILS__ . "\TemplateRenderer.php";
require_once __UTILS__ . "\TemplateCache.php";
require_once __UTILS__ . "\TemplateCompiler.php";

use Exception;

class TemplateFacade
{
    private TemplateCompiler $compiler;
    private TemplateRenderer $renderer;
    private TemplateCache $cache;

    public function __construct(string $cacheDir = __TEMPLATE_CACHE__)
    {
        $this->cache = new TemplateCache($cacheDir);
        $this->compiler = new TemplateCompiler();
        $this->renderer = new TemplateRenderer();
    }

    /**
     * Рендерит шаблон с данными.
     * @throws Exception
     */
    public function render(string $templatePath, array $data): string
    {
        if (!file_exists($templatePath)) {
            throw new Exception("Template $templatePath not found");
        }

        $cacheFile = $this->cache->getCacheFile($templatePath);

        if (!$this->cache->isFresh($cacheFile, $templatePath)) {
            $templateContent = file_get_contents($templatePath);
            $phpCode = $this->compileTemplate($templateContent);
            $this->cache->write($cacheFile, $phpCode);
        }

        return $this->renderer->render($cacheFile, $data);
    }

    /**
     * Компилирует шаблон в PHP-код.
     */
    private function compileTemplate(string $template): string
    {
        return $this->compiler->compile($template);
    }
}