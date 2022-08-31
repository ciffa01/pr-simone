<?php
	namespace SimpleRest\endpoints;

	use \SimpleRest\helpers\CommonRequest;
	use \SimpleRest\http\Info;
	use \SimpleRest\replies\Ok;

	class Hello extends CommonRequest {
		public function reply() {
			if ($this->method != Info::METHOD_GET) {
				return parent::reply();
			}

			$reply = new Ok();
			$reply
				->contentType(Info::CONTENT_TYPE_TEXT)
				->payload("Hello world");

			return $reply;
		}
	}