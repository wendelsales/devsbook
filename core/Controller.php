<?php

namespace core;

use \src\Config;

class Controller
{

    protected function redirect($url)
    {
        header("Location: " . $this->getBaseUrl() . $url);
        exit;
    }

    private function getBaseUrl()
    {
        $base = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':' . $_SERVER['SERVER_PORT'];
        }
        $base .= Config::BASE_DIR;

        return $base;
    }

    private function _render($folder, $viewName, $viewData = [])
    {
        if (file_exists('../src/views/' . $folder . '/' . $viewName . '.php')) {
            extract($viewData);
            $render = fn ($viewName, $viewData = []) => $this->renderPartial($viewName, $viewData);
            $base = $this->getBaseUrl();
            require '../src/views/' . $folder . '/' . $viewName . '.php';
        }
    }

    //Faz a mesma coisa que a variavel $render dentro do método _render()
    public function renderComponent($viewName = '', $viewData = [])
    {
        $this->renderPartial($viewName, $viewData);
    }

    private function renderPartial($viewName, $viewData = [])
    {
        $this->_render('partials', $viewName, $viewData);
    }

    public function render($viewName, $viewData = [])
    {
        $this->_render('pages', $viewName, $viewData);
    }
}
