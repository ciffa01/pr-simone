<?php
	namespace SimpleRest\http;

	class Info {
		const METHOD_GET = "GET";
		const METHOD_POST = "POST";
		const METHOD_PUT = "PUT";
		const METHOD_DELETE = "DELETE";
		const METHOD_PATCH = "PATCH";
		const METHOD_OPTIONS = "OPTIONS";

		// // Informational 1xx
		const CODE_CONTINUE = 100;
		const CODE_SWITCHING_PROTOCOLS = 101;
		// // Successful 2xx
		const CODE_OK = 200;
		const CODE_CREATED = 201;
		const CODE_ACCEPTED = 202;
		const CODE_NON_AUTHORITATIVE_INFORMATION = 203;
		const CODE_NO_CONTENT = 204;
		const CODE_RESET_CONTENT = 205;
		// // Redirection 3xx
		const CODE_MULTIPLE_CHOICES = 300;
		const CODE_MOVED_PERMANENTLY = 301;
		const CODE_FOUND = 302;
		const CODE_SEE_OTHER = 303;
		const CODE_USE_PROXY = 305;
		//const CODE_ = 306; // 306 (unused)
		const CODE_TEMPORARY_REDIRECT = 307;
		// // Client Error 4xx
		const CODE_BAD_REQUEST = 400;
		const CODE_PAYMENT_REQUIRED = 402;
		const CODE_FORBIDDEN = 403;
		const CODE_NOT_FOUND = 404;
		const CODE_METHOD_NOT_ALLOWED = 405;
		const CODE_NOT_ACCEPTABLE = 406;
		const CODE_REQUEST_TIMEOUT = 408;
		const CODE_CONFLICT = 409;
		const CODE_GONE = 410;
		const CODE_LENGTH_REQUIRED = 411;
		const CODE_PAYLOAD_TOO_LARGE = 413;
		const CODE_URI_TOO_LONG = 414;
		const CODE_UNSUPPORTED_MEDIA_TYPE = 415;
		const CODE_EXPECTATION_FAILED = 417;
		const CODE_UPGRADE_REQUIRED = 426;
		// // Server Error 5xx
		const CODE_INTERNAL_SERVER_ERROR = 500;
		const CODE_NOT_IMPLEMENTED = 501; // Not Implemented
		const CODE_BAD_GATEWAY = 502;
		const CODE_SERVICE_UNAVAILABLE = 503;
		const CODE_GATEWAY_TIMEOUT = 504;
		const CODE_HTTP_VERSION_NOT_SUPPORTED = 505;

		const CONTENT_TYPE_UNKNOWN = "application/octet-stream";
		const CONTENT_TYPE_TEXT = "text/plain";
		const CONTENT_TYPE_JSON = "application/json";
		const CONTENT_TYPE_NO_CONTENT = "no content response";

		const CONTENT_TYPE_IMAGE_GIF = "image/gif";
		const CONTENT_TYPE_IMAGE_JPEG = "image/jpeg";
		const CONTENT_TYPE_IMAGE_PNG = "image/png";
		const CONTENT_TYPE_IMAGE_SVG = "image/svg+xml";
		const CONTENT_TYPE_IMAGE_TIFF = "image/tiff";
		const CONTENT_TYPE_IMAGE_WEBP = "image/webp";
		const CONTENT_TYPE_IMAGE_AVIF = "image/avif";

		const CONTENT_TYPE_JAVASCRIPT = "application/javascript";
		const CONTENT_TYPE_CSS = "text/css";
		const CONTENT_TYPE_HTML = "text/html";

		const CONTENT_TYPE_TEXT_CSV = "text/csv";
		const CONTENT_TYPE_MSWORD_DOC = "application/msword";
		const CONTENT_TYPE_MSWORD_DOCX = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
		const CONTENT_TYPE_PDF = "application/pdf";
		const CONTENT_TYPE_MSEXCEL_XLS = "application/vnd.ms-excel";
		const CONTENT_TYPE_MSEXCEL_XLSX = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
		const CONTENT_TYPE_XML = "application/xml";
		const CONTENT_TYPE_ZIP = "application/zip";

		const HEADER_SEPARATOR = ": ";
	}