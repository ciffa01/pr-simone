<?php
	namespace SimpleRest\helpers;

	interface IResponse {
		public function __construct();
		public function code($code);
		public function headers($headers);
		public function contentType($contentType);
		public function payload($payload);

		public function getCode();
		public function getHeaders();
		public function getContentType();
		public function getPayload();
	}