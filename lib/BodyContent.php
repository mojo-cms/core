<?php
namespace mj\core;

interface BodyContent
{
	public function isNamedFile();
	public function isStream();

	public function filePath();
	public function stream();
	public function content();
	public function length();
}