<?php

require_once("Clients.class.php");
require_once("Response.class.php");

/**
 * Class Router
 *
 * Calls appropriate methods for content.
 */
class Router{
	public static $routes = array();

    /**
     * @param $httpMethod
     * @param $path
     * @param $controller
     * @param $action
     * Adds route to collection.
     */
    public static function addRoute($httpMethod, $path, $controller, $action){
		static::$routes[] = array(
			'httpMethod'	=> $httpMethod,
			'path'			=> $path,
			'controller'	=> $controller,
			'action'		=> $action
		);
	}

    /**
     * Executes the asked route.
     * @param $httpMethod
     * @param $path
     *
     */
    public static function doRoute($httpMethod, $path){
        $request = explode("/", strtok($path, '?'));
        array_shift($request);
        $requestSettings = Router::validateUrl($request);
        foreach(Router::$routes as $route){
            if(preg_match("/(".$requestSettings['preg'].")$/", $route['path']) && !empty($requestSettings['preg'])){
                if($httpMethod == $route['httpMethod'] ){
                    $params = call_user_func_array( array( new $route['controller'], $route['action']), $requestSettings['params'] );
                    $response = new Response($params['code'], $params['message'], $params['type'], $params['data']);
                    $response->send();
                    break;
                }else{
                    $response = new Response(405, 'Bad method.', 'application/json', '');
                }
            }else{
                $response = new Response(404, 'Page not found.' , 'application/json', '');
            }
        }
        $response->send();
    }

    /**
     * @param $request
     * @return string
     * Builds Regex depending on URL
     */
    private static function validateUrl($request){
        $grepStr = "";
        $params = array();
        foreach($request as $param){
            if(is_numeric($param)){
                array_push($params, $param);
                $grepStr .= "\{\w+\}"."\/";
            }else{
                $grepStr .= $param."\/";
            }
        }
        return array('preg' => substr($grepStr,0,-2), 'params' => $params);
    }
}
