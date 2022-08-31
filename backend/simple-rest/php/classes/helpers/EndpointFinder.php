<?php
	namespace SimpleRest\helpers;

	class EndpointFinder {
		const FALLBACK_ENDPOINT_CLASSNAME = "\\SimpleRest\\helpers\\CommonRequest";
		const IREQUEST_INTERFACE = "SimpleRest\\helpers\\IRequest";
		const IHYPER_INTERFACE = "SimpleRest\\helpers\\IHyper";

		static protected $unusedPath = [];

		static protected function camelize($txt) {
			return preg_replace_callback("/[_\- ](\w)/", function ($matches) {
				return strtoupper($matches[1]);
			}, strtolower($txt));
		}

		static public function findByPath($path) {
			$pathComponents = array_filter(explode("/", $path), function($item) {
				return !empty($item);
			});

			$className = "\\SimpleRest\\endpoints\\".implode("\\", array_map(function($item) {
				return ucfirst(self::camelize($item));
			}, $pathComponents));

			if (!class_exists($className, true)) {
				$className = self::FALLBACK_ENDPOINT_CLASSNAME;
			}

			$implementations = class_implements($className);

			if (!in_array(self::IREQUEST_INTERFACE, $implementations)) {
				$className = self::FALLBACK_ENDPOINT_CLASSNAME;
			}
			
			if (in_array(self::IHYPER_INTERFACE, $implementations)) {
				$section = $className::getHyperSection();
				$action = $className::getHyperAction();

				\CommonHelpers::includeHyper(empty($section) ? \Config::HYPER_DEFAULT_SECTION : $section, empty($action) ? \Config::HYPER_DEFAULT_ACTION : $section);
			}

			$endpoint = new $className();

			return $endpoint;
		}

		static public function findByPartialPath($path) {
			$pathComponents = array_filter(explode("/", $path), function($item) {
				return !empty($item);
			});

			$className = null;
			self::$unusedPath = [];

			while (!empty($pathComponents)) {
				$targetClassName = "\\SimpleRest\\endpoints\\".implode("\\", array_map(function($item) {
					return ucfirst(self::camelize($item));
				}, $pathComponents));

				if (class_exists($targetClassName, true)) {
					$className = $targetClassName;
					break;
				}
				
				array_unshift(self::$unusedPath, array_pop($pathComponents));
			}

			if ($className === null) {
				$className = self::FALLBACK_ENDPOINT_CLASSNAME;
			}

			$implementations = class_implements($className);

			if (!in_array(self::IREQUEST_INTERFACE, $implementations)) {
				$className = self::FALLBACK_ENDPOINT_CLASSNAME;
			}
			
			if (in_array(self::IHYPER_INTERFACE, $implementations)) {
				$section = $className::getHyperSection();
				$action = $className::getHyperAction();

				\CommonHelpers::includeHyper(empty($section) ? \Config::HYPER_DEFAULT_SECTION : $section, empty($action) ? \Config::HYPER_DEFAULT_ACTION : $section);
			}

			$endpoint = new $className();

			return $endpoint;
		}

		static public function getLastUnusedPath() {
			return self::$unusedPath;
		}
	}