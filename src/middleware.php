<?php
use Slim\Http\Request;
use Slim\Http\Response;
// Application middleware

$mw = function (Request $request, Response $response, $next) use ($app) {
    $requestHeaders = apache_request_headers();
    if (!isset($requestHeaders['authorization']) && !isset($requestHeaders['Authorization'])) {
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json; charset=utf-8');
        return $response->withJson(array("message" => "No token provided."));
    }

    $authorizationHeader = isset($requestHeaders['authorization']) ? $requestHeaders['authorization'] : $requestHeaders['Authorization'];

    if ($authorizationHeader == null) {
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json; charset=utf-8');
        return $response->withJson(array("message" => "No authorization header sent."));
    }

    $authorizationHeader = str_replace('bearer ', '', $authorizationHeader);
    $token = str_replace('Bearer ', '', $authorizationHeader);

    try {
        $this->token->setCurrentToken($token);
    }
    catch(\Auth0\SDK\Exception\CoreException $e) {
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json; charset=utf-8');
        return $response->withJson(array("message" => $e->getMessage()));
    }
    $putReq = substr($request->getRequestTarget(), 0, 21);
    if (!((array)$this->token->getTokenInfo())['https://hack2018api.com/email']) {
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json; charset=utf-8');
        return $response->withJson(array("message" => "No mail verified"));
    }
    //Set Group
    $group = new Classes\Group($request);
    //Set Role
    $role = new Classes\Role($this->token->getTokenInfo());
    //Controllo sui permessi in base al ruolo
    if ($role->getRole() !== 'admin') {
        if ($role->getRole() !== 'staff') {
            if ($role->getRole() !== 'user') {
                header('HTTP/1.0 401 Unauthorized');
                header('Content-Type: application/json; charset=utf-8');
                return $response->withJson(array("message" => "No role provided."));
            } else {
                if ($role->getRole() !== $group->getGroup()) {
                    header('HTTP/1.0 401 Unauthorized');
                    header('Content-Type: application/json; charset=utf-8');
                    return $response->withJson(array("message" => "Access denied."));
                }
            }
        } else {
            if ($group->getGroup() === 'admin') {
                header('HTTP/1.0 401 Unauthorized');
                header('Content-Type: application/json; charset=utf-8');
                return $response->withJson(array("message" => "Access denied."));
            }
        }
    }
    return $response = $next($request, $response);
};
