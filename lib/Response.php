<?php
namespace mj\core;

use mj\core\BodyContent;
use mj\core\ResourceBody;
use mj\core\StringBody;

class Response
{
	public static function cast($thing) {
		if ($thing instanceof self) {
			return $thing;
		} else if (is_array($thing)) {
			$response = new self;
			if (isset($thing[0])) {
				$response->setStatus($thing[0]);
				$response->setHeaders($thing[1]);
				$response->setBody($thing[2]);
			} else {
				$response->setStatus($thing['status']);
				$response->setHeaders($thing['headers']);
				$response->setBody($thing['body']);
			}
			return $response;
		} else {
			throw new \Exception("cannot cast value to mj\\core\\Response");
		}
	}

	private $status = 200;
	private $headers = [];
	private $body = '';
	private $bodyObject = null;

	public function status() { return $this->status; }
	public function headers() { return $this->headers; }
	public function body() {
		if (!$this->bodyObject) {
			$this->bodyObject = $this->makeBody($this->body);
		}
		return $this->bodyObject;
	}

	public function setStatus($status) { $this->status = (int) $status; }
	public function setHeaders($headers) { $this->headers = $headers; }
	public function setBody($body) { $this->body = $body; $this->bodyObject = null; }

	public function finalize() {
		if (isset($this->headers['Content-Length'])) {
			$bodyLength = $this->body()->length();
			if ($bodyLength) {
				$this->headers['Content-Length'] = $bodyLength;
			}
		}
	}

	protected function makeBody($body) {
		if ($body instanceof BodyContent) {
			return $body;
		} else if (is_resource($body)) {
			return new ResourceBody($body);
		} else {
			return new StringBody((string) $body);
		}
	}
}
