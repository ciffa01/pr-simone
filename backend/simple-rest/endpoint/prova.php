<?php
    namespace SimpleRest\endpoints;

	use \SimpleRest\helpers\CommonRequest;
	use \SimpleRest\http\Info;
	use \SimpleRest\replies\Ok;

	class AJsonPost extends CommonRequest {
		public function reply() {
			if (!in_array($this->method, array(Info::METHOD_POST))) {
				return parent::reply();
			}

			$payload = array();

			if (is_array($this->request)) {
				foreach ($this->request as $key => $value) {
					$payload[$key] = $value;
				}
			}


			$reply = new Ok();
			$reply
				->contentType(Info::CONTENT_TYPE_JSON)
				->payload(json_encode($payload));

			return $reply;
		}
	}
