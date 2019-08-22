<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Import Monolog classes into the global namespace
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$container = $app->getContainer();

$container["logger"] = function ($c) {
	// create a log channel
	$log = new Logger("api");
	$log->pushHandler(new StreamHandler(__DIR__ . "/../logs/app.log", Logger::INFO));

	return $log;
};

/**
 * This method restricts access to addresses. <br/>
 * <b>post: </b>To access is required a valid token.
 */
$app->add(new \Slim\Middleware\JwtAuthentication([
	// The secret key
	"secret" => SECRET,
	"rules" => [
		new \Slim\Middleware\JwtAuthentication\RequestPathRule([
			// Degenerate access to "/api"
			"path" => "/api",
			// It allows access to "login" without a token
			"passthrough" => [
				"/api/v1/authorize",
				"/api/v1/verify/token"
			]
		])
	]
]));

/**
 * This method settings CORS requests
 *
 * @param	\Psr\Http\Message\ServerRequestInterface	$request	PSR7 request
 * @param	\Psr\Http\Message\ResponseInterface      	$response	PSR7 response
 * @param	callable                                 	$next     	Next middleware
 *
 * @return	\Psr\Http\Message\ResponseInterface
 */
$app->add(function (Request $request, Response $response, $next) {
	$response = $next($request, $response);
	// Access-Control-Allow-Origin: <domain>, ... | *
	$response = $response->withHeader('Access-Control-Allow-Origin', '*')
		->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
	return $response;
});

/**
 * This method creates an urls group. <br/>
 * <b>post: </b>establishes the base url "/public/api/v1/".
 */
$app->group("/api/v1", function () use ($app) {
	/**
	 * This method is used for testing the api.<br/>
	 *
	 * @param	\Psr\Http\Message\ServerRequestInterface	$request	PSR7 request
	 * @param	\Psr\Http\Message\ResponseInterface      	$response	PSR7 response
	 *
	 * @return	string
	 */
	$app->get("/authorize", function (Request $request, Response $response) {
		
		$data["status"] = "success";
		$data["token"] = JWTAuth::getToken(CMID, CMNAME);
		
		// Return the result
		$response = $response->withHeader("Content-Type", "application/json");
		$response = $response->withStatus(200, "Success");
		$response = $response->withJson($data);
		//$response = $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
		return $response;
	});

	$app->post("/verify/token", function (Request $request, Response $response) {
		// Gets the token of the header.
		// Authorization: Bearer {token}
		/** @var string $token - Token */
		$token = str_replace("Bearer ", "", $request->getServerParams()["HTTP_AUTHORIZATION"]);
		$result = JWTAuth::verifyToken($token);
		if ($result) {
			$data["status"] = "success";
			$data["message"] = "Authentication token is valid.";
		} else {
			$data["status"] = "failure";
			$data["message"] = "Authentication token is invalid.";			
		}
		
		// Return the result
		$response = $response->withHeader("Content-Type", "application/json");
		$response = $response->withStatus(200, "Success");
		$response = $response->withJson($data);

		return $response;
	});
});

?>
