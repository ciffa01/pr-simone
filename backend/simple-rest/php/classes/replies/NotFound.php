<?php
	namespace SimpleRest\replies;

	class NotFound extends \SimpleRest\helpers\CommonResponse {
		public function __construct() {
			parent::__construct();

			$this->code(\SimpleRest\http\Info::CODE_NOT_FOUND);
		}
	}