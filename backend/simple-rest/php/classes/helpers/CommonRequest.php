<?php
	namespace SimpleRest\helpers;

	class CommonRequest implements IRequest {
		protected $method;
		protected $endpoint;
		protected $headers;
		protected $request;
		protected $payload;

		public function __construct() {
			$this->request = array();
		}

		public function setMethod($method) {
			$this->method = $method;

			return $this;
		}

		public function setEndpointPath($path) {
			$this->endpoint = $path;

			return $this;
		}

		public function setHeaders($headers) {
			$this->headers = $headers;

			return $this;
		}

		public function setRequest($request) {
			$this->request = $request;

			return $this;
		}

		public function setPayload($payload) {
			$this->payload = $payload;

			return $this;
		}

		public function reply() {
			return new \SimpleRest\replies\NotImplemented();
		}

		public function preflightReply($method, $serverHeaders)	{
			return new \SimpleRest\replies\Preflight();
		}
	}