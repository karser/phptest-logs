<?php
namespace Karser\Core;

class Dispatcher
{
    /** @var array */
    private $closures = [];

    public function addClosure($path, callable $closure)
    {
        $this->closures[$path] = $closure;
    }

    /** @var string */
    private $path;

    private function resolve(Request $r)
    {
        $actualPath = $r->getPath();
        foreach ($this->closures as $path => $closure) {
            if ($actualPath === $path) {
                return $closure;
            }
        }
        throw new \Exception('wrong path');
    }

    public function run()
    {
        $r = new Request();
        $r->createFromGlobals();
        $closure = $this->resolve($r);
        $response = call_user_func($closure, $r);
        $this->handleResponse($response);
    }

    /**
     * @param $response $response
     * @throws \Exception
     */
    private function handleResponse($response)
    {
        if ($response instanceof ResponseRedirect) {
            header('location: '.$response->getRedirectUrl());
            die();
        } elseif ($response instanceof Response) {
            echo $response->getContent();
            die();
        }
        throw new \Exception('wrong response given');
    }
}
