<?php
namespace mj\core;

use mj\core\BodyContent;

class ResourceBody implements BodyContent
{
    private $resource;

    public function __construct($resource) {
        $this->resource = $resource;
    }

    public function isNamedFile() { return false; }
    public function isStream() { return true; }

    public function filePath() { throw new \Exception(); }
    public function stream() { return $this->resource; }
    public function content() { throw new \Exception(); }
    public function length() { return null; }
}