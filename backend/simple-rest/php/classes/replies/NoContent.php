<?php
	namespace SimpleRest\replies;

	class NoContent extends \SimpleRest\helpers\CommonResponse {
		public function __construct() {
			parent::__construct();

			$this->code(\SimpleRest\http\Info::CODE_NO_CONTENT);
		}
	}