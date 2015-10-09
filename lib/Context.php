<?php
namespace mj\core;

class Context
{
	public $router = null;
	public $errorHandler = "\\mojo\\core\\default_error_handler";
	public $missingRouteHandler = "\\mojo\\core\\default_missing_route_handler";
}

class default_error_handler {
	public function __dispatch($request, $params) {
		return [
			500,
			[ 'Content-Type' => 'text/html' ],
			'<h1>500 Internal Server Error</h1>'
		];
	}
}

class default_missing_route_handler {
	public function __dispatch($request, $params) {
		return [
			404,
			[ 'Content-Type' => 'text/html' ],
			'<h1>404 Not Found</h1>'
		];
	}
}