<?php
namespace mj\core;

use mj\core\BodyContent;

class StringBody implements BodyContent
{
	private $body;

	public function __construct($body) {
		$this->body = (string) $body;
	}

	public function isNamedFile() { return false; }
	public function isStream() { return false; }

	public function filePath() { throw new \Exception(); }
	public function stream() { throw new \Exception(); }
	public function content() { return $this->body; }
	public function length() { return strlen($this->body); }
}