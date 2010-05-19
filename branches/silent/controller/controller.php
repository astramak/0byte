<?php

class Controller {

	private $request = array();

	/**
	 * Controller constructor
	 * @param $request array
	 */
	public function __construct($request = array()) {
		if (defined('DEBUG')) {
			FB::log($request, get_class($this));
		}

		$this->request = $request;
	}

	/**
	 * Return the next part of request
	 * @return string
	 */
	protected function requestPart() {
		return array_shift($this->request);
	}

	/**
	 * Called if requested method is not defined
	 * @param $request_part string
	 */
	protected function method_undefined($request_part) {
		// not found by default
		$this->not_found();
	}

	/**
	 * Called if no method is requested
	 *
	 */
	protected function method_empty() {
		// not found by default
		$this->not_found();
	}

	protected function not_found() {
		// it is wrong path by default
		header("HTTP/1.1 404 Not Found");
		die();
	}

	/**
	 * Output string
	 * @param $what string
	 * @param $ctype string
	 */
	protected function output($what = '', $ctype = '') {
		if ($ctype != '') {
			header('Content-Type: ' . $ctype);
		}

		echo $what;
	}

	/**
	 * Handling a request
	 */
	public function handle() {
		$next = $this->requestPart();

		if (!$next) {
			if (defined('DEBUG')) {
				FB::log('empty method', get_class($this));
			}

			// for empty method
			return $this->empty();
		}

		if (!method_exists($this, $next)) {
			if (defined('DEBUG')) {
				FB::log('undefined method', get_class($this));
			}

			// for undefined method
			return $this->method_undefined($next);
		}

		if (defined('DEBUG')) {
			FB::log('method [' . $next . ']', get_class($this));
		}

		// or run it
		return $this->$next();
	}

}
