<?php
namespace mj\core;

class Dispatcher
{
    private $context;
    private $router;

    public function __construct(Context $context) {
        $this->context = $context;
        $this->router = $context->router;
    }

    public function dispatch($request) {
        $resolved = $this->router->findRoute($request);
        if ($resolved) {
            try {
                return $this->invoke($resolved->handler, $request, $resolved->params);  
            } catch (\Exception $e) {
                return $this->invoke($this->context->errorHandler, $request, []);
            }
        }
        return $this->invoke($context->missingRouteHandler, $request, []);
    }

    private function invoke($target, $request, $matches) {
        if (is_string($target)) {
            $ctl = new $target;
            return $ctl->__dispatch($request, $matches);
        } else if (is_callable($target)) {
            return $target($request, $matches);
        } else if (is_object($target)) {
            return $target->__dispatch($request, $matches);
        } else {
            // TODO: need a system-level exception
            throw new \Exception("invalid route handler");
        }
    }
}
