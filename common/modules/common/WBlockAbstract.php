<?php
namespace common\modules\common;

abstract class WBlockAbstract
{
    protected $params;
    protected $templatePath;
    protected $res;

    protected function __construct(string $templatePath, array $params = [])
    {
        $path = static::getBaseDir() . '/views/' . $templatePath;
        if(!is_file($path)) {
            throw new \ErrorException("Не найден файл {$path}.");
        }
        $this->params = $params;
        $this->templatePath = $path;

        $this->init();
    }

    abstract protected static function getBaseDir(): string ;

    abstract protected function init();

    protected function render()
    {
        static::includeView($this->templatePath, $this->res);
    }

    protected static function includeView(string $path, array $res, bool $return = false)
    {
        include $path;
    }

    public static function getHtml(string $templatePath, array $params = []): string
    {
        $self = new static($templatePath, $params);
        ob_start();
        $self->render();
        return ob_get_clean();
    }

    public static function incl(string $templatePath, array $params = [])
    {
        $self = new static($templatePath, $params);
        $res =& $self->res;
        return include $self->templatePath;
    }
}