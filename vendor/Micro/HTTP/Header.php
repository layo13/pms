<?php

namespace Micro\HTTP;

class Header {

	private $contentType;
	private $charset;

	public function __construct($contentType, $charset = "") {
		$this->contentType = $contentType;
		$this->charset = $charset;
	}

	public function __toString() {
		return "Content-Type: " . $this->contentType . ($this->charset != "" ? ";Charset=" . $this->charset : "");
	}

}
