<?php
namespace mj\core;

use mj\core\BodyContent;

class FileBody implements BodyContent
{
	public function __construct($filename) {
		$this->filename = $filename;
	}

	public function isNamedFile() { return true; }
	public function isStream() { return false; }

	public function filePath() { return $this->filename; }
	public function stream() { throw new \Exception(); }
	public function content() { throw new \Exception(); }
	public function length() { return filesize($this->filename); }
}