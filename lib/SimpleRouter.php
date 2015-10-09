<?php
namespace mojo\core;

class SimpleRouter implements Router
{
    private $routes = [];

    public function route($path, $opts = []) {
        $route = new Route;
        $route->route = $this->regexify($path);
        $route->target = $opts['to'];
        $route->defaultParams = isset($opts['params']) ? $opts['params'] : [];
        $this->routes[] = $route;
    }

    public function findRoute(\mojo\http\Request $request) {
        foreach ($this->routes as $route) {
            $match = $route->match($request);
            if ($match) {
                return $match;
            }
        }
        return null;
    }

    private function regexify($path) {
        $path = preg_replace('/:(\w+)/', '(?P<\\1>[^/]+)', $path);
        $path = '/' . $path;
        $path = '|^' . $path . '$|';
        return $path;
    }
}

class Route
{
    public $route;
    public $target;
    public $defaultParams;

    public function match($request) {
        $matches = null;
        if (preg_match($this->route, $request->path(), $matches)) {
            return new ResolvedRoute(
                $this->target,
                $matches + $this->defaultParams
            );
        } else {
            return false;
        }
    }
}