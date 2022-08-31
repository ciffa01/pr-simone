<?php
	class Config {
		const LOGGING = false; // enable / disable logging
		const LOG_FILE = "../log.txt";

		const PATH_TO_AUTOLOADER_CLASS = ""; // se vuota, usa il proprio autoloader; quello di hyper è normalmente in "../"
		const PATH_TO_LIB_HYPERCOM = "";  // usato solo se l'endpoint implementa IHyper

		const AUTOLOADER_CLASS_NAME = ""; // se vuoto, default su "hyperAutoloader";

		const CUSTOM_HEADERS_PREFIX = "";

		const HYPER_DEFAULT_SECTION = "section"; // usato solo se l'endpoint implementa IHyper
		const HYPER_DEFAULT_ACTION = "action"; // usato solo se l'endpoint implementa IHyper

		const ENDPOINTS_NAMESPACE_PATH = "../php/classes/endpoints";

		const MAX_JSON_PAYLOAD_SIZE = 5000; // bytes

		static public function getAdditionalNamespaces() {
			$namespaces = array(); // format: "namespace" => "path"

			return $namespaces;
		}
	}