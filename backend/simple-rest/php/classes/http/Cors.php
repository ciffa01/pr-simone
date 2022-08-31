<?php
	namespace SimpleRest\http;

	class Cors {
		const PREFLIGHT_METHOD = Info::METHOD_OPTIONS;

		const HEADER_ACCESS_CONTROL_ALLOW_ORIGIN = "Access-Control-Allow-Origin";
		const HEADER_ACCESS_CONTROL_ALLOW_METHODS = "Access-Control-Allow-Methods";
		const HEADER_ACCESS_CONTROL_ALLOW_HEADERS = "Access-Control-Allow-Headers";
		const HEADER_ACCESS_CONTROL_MAX_AGE = "Access-Control-Max-Age";
		const HEADER_ACCESS_CONTROL_ALLOW_CREDENTIALS = "Access-Control-Allow-Credentials";
		const HEADER_ACCESS_CONTROL_EXPOSE_HEADERS = "Access-Control-Expose-Headers";

		const HEADER_ACCESS_CONTROL_REQUEST_ORIGIN = "Origin";
		const HEADER_ACCESS_CONTROL_REQUEST_METHOD = "Access-Control-Request-Method";
		const HEADER_ACCESS_CONTROL_REQUEST_HEADERS = "Access-Control-Request-Headers";
		const HEADER_ACCESS_CONTROL_DEFAULT_MAX_AGE = 86400;

		const ALL_ORIGINS = "*";
		const ALL_METHODS = [
			\SimpleRest\http\Info::METHOD_GET,
			\SimpleRest\http\Info::METHOD_POST,
			\SimpleRest\http\Info::METHOD_PUT,
			\SimpleRest\http\Info::METHOD_DELETE,
			\SimpleRest\http\Info::METHOD_PATCH,
			\SimpleRest\http\Info::METHOD_OPTIONS
		];
		const ALL_HEADERS = "*";
		const ALL_EXPOSE_HEADERS = "*";
		const ALLOW_CREDENTIALS = "true";

		static protected function getPreflightParametersHeaders() {
			return [
				self::HEADER_ACCESS_CONTROL_REQUEST_METHOD,
				self::HEADER_ACCESS_CONTROL_REQUEST_HEADERS,
				self::HEADER_ACCESS_CONTROL_REQUEST_ORIGIN
			];
		}

		static protected function getPreflightParametersKeys() {
			return array_map("self::headerToServerKey", self::getPreflightParametersHeaders());
		}

		static protected function headerToServerKey($header) {
			return "HTTP_".strtoupper(str_replace("-", "_", $header));
		}

		static public function allMethodsAsString() {
			return implode(", ", self::ALL_METHODS);
		}

		static public function isPreflightRequest($method, $serverHeaders) {
			if ($method !== self::PREFLIGHT_METHOD) {
				return false;
			}

			$checks = self::getPreflightParametersKeys();
			$checks = array_map(function($check) use ($serverHeaders) {
				return array_key_exists($check, $serverHeaders);
			}, $checks);

			return !in_array(false, $checks, true);
		}

		static public function getPreflightParameters($serverHeaders) {
			$headers = self::getPreflightParametersHeaders();
			$parameters = array_reduce($headers, function($accu, $header) use ($serverHeaders) {
				$key = self::headerToServerKey($header);

				if (array_key_exists($key, $serverHeaders)) {
					$accu[$header] = array_map("trim", explode(",", $serverHeaders[$key]));
				}

				return $accu;
			}, []);

			return $parameters;
		}
	}