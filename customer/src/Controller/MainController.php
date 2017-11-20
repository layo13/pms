<?php

namespace Controller;

use Micro\HTTP\Header;
use Micro\HTTP\ContentType;
use Micro\HTTP\Charset;

class MainController {

	/**
	 * @pattern /
	 * @return string
	 */
	public function homeAction() {
		header(new Header(ContentType::TEXT_XML, Charset::UTF8));
		return "<customers></customers>";
	}

	public function getCustomerList() {
		
	}
}
