<?php
namespace mj\core;

class WebResponseWriter
{
	public function write($response) {
		http_response_code($response->status());
		foreach ($response->headers() as $header => $value) {
			header("{$header}: {$value}");
		}
		$body = $response->body();
		if ($body->isNamedFile()) {
			if ($this->useSendFile()) {
				header("X-Sendfile: " . $body->filePath());
			} else {
				readfile($body->filePath());
			}
		} else if ($body->isStream()) {
			stream_copy_to_stream($body->stream(), fopen('php://output', 'w'));
		} else {
			echo $body->content();
		}
	}

	// TODO: set this somehow...
	public function useSendFile() {
		return false;
	}
}