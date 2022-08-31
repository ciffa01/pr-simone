<?php
	require_once "../CommonHelpers.php";

	CommonHelpers::includeAutoloader();
	
	// $loader = new hyperAutoloader();
	$loader = CommonHelpers::getAutoloaderInstance();
	$loader->add_namespace('SimpleRest\http', '../php/classes/http');
	$loader->add_namespace('SimpleRest\helpers', '../php/classes/helpers');
	$loader->add_namespace('SimpleRest\endpoints', Config::ENDPOINTS_NAMESPACE_PATH);
	$loader->add_namespace('SimpleRest\replies', '../php/classes/replies');
	
	$additionalNamespaces = Config::getAdditionalNamespaces();

	foreach ($additionalNamespaces as $namespace => $path) {
		$loader->add_namespace($namespace, $path);
	}

	$loader->register();
	
	// METHOD
	$method = strtoupper($_SERVER["REQUEST_METHOD"]);

	// HEADERS
	$headers = getallheaders();
	
	// REQUEST
	$request = $_REQUEST;
	unset($request[CommonHelpers::ENDPOINT_PATH_KEY]);

	if (empty($request)) {
		$request = null;
	}

	// PAYLOAD
	if ($method != \SimpleRest\http\Info::METHOD_GET) {
		ini_set("enable_post_data_reading", "true");
	}

	$requestContentType = array_key_exists("CONTENT_TYPE", $_SERVER) ? $_SERVER["CONTENT_TYPE"] : \SimpleRest\http\Info::CONTENT_TYPE_NO_CONTENT;
	$requestContent = file_get_contents('php://input');

	if (CommonHelpers::isAllowedRequest($requestContentType, $requestContent)) {
		$payload = json_decode($requestContent, true);

		if (json_last_error() != JSON_ERROR_NONE) {
			$payload = $requestContent;
		}
		
		$endpoint = \SimpleRest\helpers\EndpointFinder::findByPartialPath($_REQUEST[CommonHelpers::ENDPOINT_PATH_KEY]);

		$request[\SimpleRest\helpers\SimpleRest::TRAILING_PATH_KEY] = \SimpleRest\helpers\EndpointFinder::getLastUnusedPath(); 

		if (\SimpleRest\http\Cors::isPreflightRequest($method, $_SERVER)) {
			$reply = $endpoint->preflightReply($method, $_SERVER);
		} else {
			$reply = $endpoint
				->setMethod($method)
				->setHeaders($headers)
				->setRequest($request)
				->setPayload($payload)
				->reply();
		}

		if (!is_a($reply, "\\SimpleRest\\helpers\\IResponse")) {
			$reply = new \SimpleRest\replies\InternalServerError();
		}

		\SimpleRest\helpers\Logger::writeLog($method, $_REQUEST[CommonHelpers::ENDPOINT_PATH_KEY], $headers, $request, $requestContent);
	} else {
		$reply = new \SimpleRest\replies\BadRequest();
	}
	
	$code = $reply->getCode();
	$responseHeaders = $reply->getHeaders();
	$contentType = $reply->getContentType();

	http_response_code($code);

	if (is_array($responseHeaders)) {
		array_walk($responseHeaders, function($header) {
			if (is_string($header)) {
				header($header);
			}
		});
	}

	switch ($contentType) {
		case \SimpleRest\http\Info::CONTENT_TYPE_NO_CONTENT:
			break;
		case \SimpleRest\http\Info::CONTENT_TYPE_JSON:
			header("Content-Type: ".$contentType."; charset=UTF-8");
			echo $reply->getPayload();

			break;
		default:
			header("Content-Type: ".$contentType);
			echo $reply->getPayload();

			break;
	}