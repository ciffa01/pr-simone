<?php
	namespace SimpleRest\replies;

	class BadRequest extends \SimpleRest\helpers\CommonResponse {
		public function __construct() {
			parent::__construct();

			$this->code(\SimpleRest\http\Info::CODE_BAD_REQUEST);
		}
	}