<?php
	namespace SimpleRest\endpoints;

	use \SimpleRest\helpers\CommonRequest;
	use \SimpleRest\helpers\SimpleRest;
	use \SimpleRest\http\Info;
	use \SimpleRest\replies\Ok;

	class Concatenator extends CommonRequest {
		public function reply() {
			if ($this->method != Info::METHOD_GET) {
				return parent::reply();
			}

			$concatenation = implode(" ", $this->request[SimpleRest::TRAILING_PATH_KEY]);

			$reply = new Ok();
			$reply
				->contentType(Info::CONTENT_TYPE_TEXT)
				->payload(empty($concatenation) ? "Nothing to concatenate" : "Concatenation: ".$concatenation);

			return $reply;
		}
	}