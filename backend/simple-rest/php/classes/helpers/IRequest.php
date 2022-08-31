<?php
	namespace SimpleRest\helpers;

	interface IRequest {
		public function __construct();
		public function setMethod($method);
		public function setEndpointPath($path);
		public function setHeaders($headers);
		public function setRequest($request);
		public function setPayload($payload);
		public function reply();
		public function preflightReply($method, $serverHeaders);
	}