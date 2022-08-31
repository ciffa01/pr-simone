<?php
	namespace SimpleRest\replies;

	class NotImplemented extends \SimpleRest\helpers\CommonResponse {
		public function __construct() {
			parent::__construct();

			$this->code(\SimpleRest\http\Info::CODE_NOT_IMPLEMENTED);
		}
	}