<?php
	namespace SimpleRest\helpers;

	class Logger {
		static function writeLog($method, $endpoint, $headers, $request, $payload) {
			if (!\Config::LOGGING) {
				return;
			}

			$now = "[".date("Y-m-d H:i:s")."]";
			$txHeaders = print_r($headers, true);
			$txRequest = print_r($request, true);

			$log = <<<TEXT
=== {$now} ====================================================================
{$method} {$endpoint}

--- HEADERS ---
{$txHeaders}

--- REQUEST ---
{$txRequest}

--- PAYLOAD ---
{$payload}




TEXT;

			file_put_contents(\Config::LOG_FILE, $log, FILE_APPEND);
		}
	}