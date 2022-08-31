<?php
	class Config {
		const LOGGING = true; // enable / disable logging
		const LOG_FILE = "../../tmp/log.txt";

		const PATH_TO_AUTOLOADER_CLASS = "../"; // se vuota, usa il proprio autoloader; quello di hyper è normalmente in "../"
		const PATH_TO_LIB_HYPERCOM = "../../hyper/";

		const AUTOLOADER_CLASS_NAME = ""; // se vuoto, default su "hyperAutoloader";

		const CUSTOM_HEADERS_PREFIX = "X_SAPIR"; // "x-sapir"

		const HYPER_DEFAULT_SECTION = "accosti";
		const HYPER_DEFAULT_ACTION = "view";

		const ENDPOINTS_NAMESPACE_PATH = "../../processi/endpoints";

		const MAX_JSON_PAYLOAD_SIZE = 10000000; // bytes

		static public function getAdditionalNamespaces() {
				$namespaces = array(
					// COMMON
					'generale' => '../../processi/generale',
					'sistema' => '../../processi/sistema',
					'utility' => '../../processi/utility',
					'coordinamento_mezzi' => '../../processi/coordinamento_mezzi',
					// PAV
					'anagrafiche' => '../../coopolis/anagrafiche',
					'allegati' => '../../coopolis/allegati',
					'db' => '../../coopolis/db',
					'dogana' => '../../processi/dogana',
					'magazzino' => '../../processi/magazzino',
					'treni' => '../../processi/treni',
					'accosti' => '../../processi/accosti',
					'scheda_nave' => '../../processi/scheda_nave',
					'pss' => '../../processi/pss',
					'sistema_gestione' => '../../processi/sistema_gestione',
					'accessi' => '../../processi/accessi',
					'personale' => '../../processi/personale'
					// COORDP
				); // format: "namespace" => "path"

			$namespaces = array(
				'utility' => '../../processi/utility',
				'accessi' => '../../processi/accessi',
				'accosti' => '../../processi/accosti',
				'coordinamento_mezzi' => '../../processi/coordinamento_mezzi',
				'generale' => '../../processi/generale',
				'sistema' => '../../processi/sistema',
				'scheda_nave' => '../../processi/scheda_nave'
			);

			return $namespaces;
		}
	}