<?php
class ResolvedRoute
{
    public function __construct($handler, $params) {
        $this->handler = $handler;
        $this->params = $params;
    }

    public $handler;
    public $params;
}