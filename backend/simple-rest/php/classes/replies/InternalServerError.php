<?php
	namespace SimpleRest\replies;

	class InternalServerError extends \SimpleRest\helpers\CommonResponse {
		public function __construct() {
			parent::__construct();

			$this->code(\SimpleRest\http\Info::CODE_INTERNAL_SERVER_ERROR);
		}
	}