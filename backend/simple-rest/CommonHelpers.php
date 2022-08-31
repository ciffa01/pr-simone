<?php
	class CommonHelpers {
		const ENDPOINT_PATH_KEY = "path";
		const DEFAULT_AUTOLOADER_CLASS_NAME = "SimpleRestHyperAutoloader";

		static public function loadConfig() {
			$lookUpPaths = [
				"../Config.simple-rest.php",
				"../Config.php",
				"../../Config.simple-rest.php",
				"../../Config.php"
			];

			foreach ($lookUpPaths as $lookUpPath) {
				if (file_exists($lookUpPath)) {
					require_once $lookUpPath;

					return;
				}
			}

			throw new Exception("Configuration Error", 1);
		}

		static public function baseDirectory() {
			return dirname(__FILE__)."/";
		}

		static public function includeAutoloader() {
			$directory = self::baseDirectory();

			if (!empty(Config::PATH_TO_AUTOLOADER_CLASS)) {
				$directory = Config::PATH_TO_AUTOLOADER_CLASS;
			}

			require_once $directory."autoloader.php";
		}

		static public function getAutoloaderInstance() {
			$className = Config::AUTOLOADER_CLASS_NAME;

			if (empty($className) || !class_exists($className)) {
				$className = self::DEFAULT_AUTOLOADER_CLASS_NAME;
			}

			return new $className();
		}

		static public function includeHyper($section = null, $action = null) {
			if (empty(Config::PATH_TO_LIB_HYPERCOM) || !is_string(Config::PATH_TO_LIB_HYPERCOM)) {
				return;
			}
			
			if (($section !== null) && ($action !== null)) {
				$_REQUEST["section"] = $section;
				$_REQUEST["action"] = $action;
			}

			require_once Config::PATH_TO_LIB_HYPERCOM."lib_hypercom.php";
		}

		static public function isAllowedRequest($contentType, $payload) {
			$allowed = true;

			if ($contentType == \SimpleRest\http\Info::CONTENT_TYPE_JSON) {
				if (Config::MAX_JSON_PAYLOAD_SIZE > 0) {
					$allowed = strlen($payload) <= Config::MAX_JSON_PAYLOAD_SIZE;
				}
			}

			return $allowed;
		}
	}

	return CommonHelpers::loadConfig();