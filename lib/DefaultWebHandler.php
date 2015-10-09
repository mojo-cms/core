<?php
namespace mojo\core;

use mojo\http\Request;

class DefaultWebHandler
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    public function run() {
        $response = Response::cast($this->dispatcher->dispatch($this->createRequest()));
        $writer = new WebResponseWriter;
        $writer->write($response);
    }

    protected function createRequest() {
        $request = new Request;
        $request->setMethod($_SERVER['REQUEST_METHOD']);
        $request->setSecure(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off');
        $host = $_SERVER['HTTP_HOST'];
        $portIx = strpos($host, ':');
        if ($portIx !== false) {
            $request->setHostname(substr($host, 0, $portIx));
            $request->setPort(substr($host, $portIx + 1));
        } else {
            $request->setHostname($host);
        }
        $request->setRequestURI($_SERVER['REQUEST_URI']);
        $request->setHeaders(getallheaders());
        return $request;
    }
}
