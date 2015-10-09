<?php
namespace mojo\core;

interface Router
{
	public function findRoute(\mojo\http\Request $req);
}
