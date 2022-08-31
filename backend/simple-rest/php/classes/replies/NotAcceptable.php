<?php
	namespace SimpleRest\replies;

	class NotAcceptable extends \SimpleRest\helpers\CommonResponse {
		public function __construct() {
			parent::__construct();

			$this->code(\SimpleRest\http\Info::CODE_NOT_ACCEPTABLE);
		}
	}