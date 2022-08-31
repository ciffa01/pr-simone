<?php
	namespace SimpleRest\replies;

	class Preflight extends NoContent {
		protected $maxAge = 86400;
		protected $CORSHeaders = [];

		public function __construct() {
			$this
				->allowOrigin(\SimpleRest\http\Cors::ALL_ORIGINS)
				->allowHeaders(\SimpleRest\http\Cors::ALL_HEADERS)
				->allowMethods(implode(", ", \SimpleRest\http\Cors::ALL_METHODS))
				->maxAge(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_DEFAULT_MAX_AGE);
			
			parent::__construct();
		}

		protected function setCORSHeader($header, $value) {
			$this->CORSHeaders[$header] = $value;

			return $this;
		}

		public function allowOrigin($siteUrl) {
			if (empty($siteUrl) || !is_string($siteUrl)) {
				$siteUrl = \SimpleRest\http\Cors::ALL_ORIGINS;
			}

			return $this->setCORSHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_ALLOW_ORIGIN, $siteUrl);
		}

		public function allowHeaders($headers) {
			if (empty($headers) || !is_array($headers)) {
				$headers = [ \SimpleRest\http\Cors::ALL_HEADERS ];
			}

			$headers = array_filter($headers, function($header) {
				return is_string($header);
			});

			return $this->setCORSHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_ALLOW_HEADERS, implode(", ", $headers));
		}

		public function allowMethods($methods) {
			if (empty($headers) || !is_array($headers)) {
				$headers = \SimpleRest\http\Cors::ALL_METHODS;
			}

			$headers = array_filter($headers, function($header) {
				return is_string($header);
			});

			return $this->setCORSHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_ALLOW_METHODS, implode(", ", $headers));
		}

		public function maxAge($maxAge) {
			if (!is_integer($maxAge)) {
				$maxAge = $this->maxAge;
			}

			if ($maxAge < 0) {
				$maxAge = 0;
			}

			return $this->setCORSHeader(\SimpleRest\http\Cors::HEADER_ACCESS_CONTROL_MAX_AGE, $maxAge);
		}

		protected function CORSSettings() {
			return array_map(function($value, $key) {
				return $this->makeHeader($key, $value);
			}, $this->CORSHeaders, array_keys($this->CORSHeaders));
		}
	}