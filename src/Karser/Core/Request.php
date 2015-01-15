<?php
namespace Karser\Core;

class Request
{
    /** @var string */
    private $uri;

    /** @var array */
    private $components = [];

    /** @var string */
    private $method;

    /** @var array */
    private $params = [];

    /** @var array */
    private $files = [];

    public function createFromGlobals()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->components = parse_url($this->uri);
        if (isset($this->components['query'])) {
            parse_str($this->components['query'], $this->params);
        }
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->files = $_FILES;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->components['path'];
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function hasFile($name)
    {
        return isset($this->files[$name]);
    }

    public function moveFile($name, $dst)
    {
        return move_uploaded_file($this->files[$name]['tmp_name'], $dst);
    }

    /**
     * @param string $param
     * @return bool
     */
    public function hasParam($param)
    {
        return isset($this->params[$param]);
    }

    /**
     * @param string $param
     * @return array
     */
    public function getParam($param)
    {
        return $this->params[$param];
    }
}
