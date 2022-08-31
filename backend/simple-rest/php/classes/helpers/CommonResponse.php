<?php
	namespace SimpleRest\helpers;

	class CommonResponse implements \SimpleRest\helpers\IResponse{
		protected $code;
		protected $headers;
		protected $contentType;
		protected $payload;

		public function __construct() {
			$this
				->code(\SimpleRest\http\Info::CODE_NOT_IMPLEMENTED)
				->headers($this->CORSSettings())
				->contentType(\SimpleRest\http\Info::CONTENT_TYPE_NO_CONTENT)
				->payload(null);
		}

		public function code($code) {
			$this->code = $code;

			return $this;
		}

		public function headers($headers) {
			if (!is_array($headers)) {
				$headers = [ $headers ];
			}

			$this->headers = $headers;

			return $this;
		}

		public function contentType($contentType) {
			$this->contentType = $contentType;

			return $this;
		}

		public function payload($payload) {
			$this->payload = $payload;

			return $this;
		}

		public function getCode() {
			return $this->code;
		}

		public function getHeaders() {
			return $this->headers;
		}

		public function getContentType() {
			return $this->contentType;
		}
		
		public function getPayload() {
			return $this->payload;
		}

		protected function makeHeader($header, $value) {
			return $header.\SimpleRest\http\Info::HEADER_SEPARATOR.$value;
		}

		protected function CORSSettings() {
			return [
				$this->makeHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_ALLOW_ORIGIN, \SimpleRest\http\Cors::ALL_ORIGINS),
				$this->makeHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_ALLOW_HEADERS, \SimpleRest\http\Cors::ALL_HEADERS),
				$this->makeHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_ALLOW_METHODS, implode(", ", \SimpleRest\http\Cors::ALL_METHODS)),
				$this->makeHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_MAX_AGE, \SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_DEFAULT_MAX_AGE)
			];
		}
	}