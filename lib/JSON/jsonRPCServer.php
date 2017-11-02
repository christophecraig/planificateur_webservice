<?php
/*
					COPYRIGHT

Copyright 2007 Sergio Vaccaro <sergio@inservibile.org>

This file is part of JSON-RPC PHP.

JSON-RPC PHP is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

JSON-RPC PHP is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JSON-RPC PHP; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * This class build a json-RPC Server 1.0
 * http://json-rpc.org/wiki/specification
 *
 * @author sergio <jsonrpcphp@inservibile.org>
 * @author Erwan Martin <emartin@sigb.net>
 */
class jsonRPCServer {
	private static function return_function_list($object, $allowed_methods) {
		//Un peu de réflexivité et le tour est joué
		ini_set("zend.ze1_compatibility_mode", "off");
		$rc = new ReflectionClass($object);
		$methods = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
		$private_methods = array("copy_error", "set_error", "clear_error", "es_proxy");
		
		$result = array();
		$result["serviceType"] = "JSON-RPC";
		$result["serviceURL"] = "http://".$_SERVER["SERVER_NAME"]."/".$_SERVER["REQUEST_URI"];
		$result["methods"] = array();
		foreach ($methods as $amethod) {
			if (in_array($amethod->name, $private_methods))
				continue;
			if(!in_array($amethod->name, $allowed_methods))
				continue;
			$amethod_result = array();
			$amethod_result["name"] = $amethod->name;
			$parameters = $amethod->getParameters();
			$amethod_result["parameters"] = array();
			foreach ($parameters as $aparam) {
				$amethod_result["parameters"][] = array(
					"name" => $aparam->name
				);
			}
			$result["methods"][] = $amethod_result;
		}
		header("Content-Type: text/json-comment-filtered");
		echo json_encode($result);
		return true;
	}
	
	/**
	 * This function handle a request binding it to a given object
	 *
	 * @param object $object
	 * @return boolean || JsonSerializable
	 */
	public static function handle($object, $allowed_methods, $json_input) {
		//var_dump(!$json_input, ($_SERVER['REQUEST_METHOD'] !=  ('GET' || 'POST')), empty($_SERVER['CONTENT_TYPE']), (strpos($_SERVER['CONTENT_TYPE'], 'application/json') === FALSE));
		
		$allowed_content_type = array(
		
		);
		// checks if a JSON-RCP request has been received
		// ----------------------------------------------
		// Origine $_SERVER['REQUEST_METHOD'] != 'POST'
		// Modifié pour les requêtes GET
		if ((
			!$json_input ||
			$_SERVER['REQUEST_METHOD'] != ('GET' || 'POST') ||
			empty($_SERVER['CONTENT_TYPE']) ||
			strpos($_SERVER['CONTENT_TYPE'], 'application/json') === FALSE )) 
		{
			//echo 'yolo1';
			//var_dump(!$json_input, ($_SERVER['REQUEST_METHOD'] !=  ('GET' || 'POST')), empty($_SERVER['CONTENT_TYPE']), (strpos($_SERVER['CONTENT_TYPE'], 'application/json') === FALSE));
			
			// Origine return self::return_function_list($object, $allowed_methods);
			// Modifié pour affichage direct dans la page
			// This is not a JSON-RPC request, we will then return the function list
			return self::return_function_list($object, $allowed_methods);
		}
				
		// reads the input data
		$request = $json_input;
		//echo 'yolo7';
		// executes the task on local object
		try {
			//echo 'yolo9';
			if (($result =@call_user_func_array(array($object,$request['method']),$request['params'])) !== FALSE) {
				$response = array (
									'id' => $request['id'],
									'result' => $result,
									'error' => NULL
									);
				//echo 'yolo2';
			} else {
				$response = array (
									'id' => $request['id'],
									'result' => NULL,
									'error' => 'unknown method or incorrect parameters'
									);
				//echo 'yolo3';
			}
			//echo 'yolo10';
		} catch (Exception $e) {
			//echo 'yolo5';
			$response = array (
								'id' => $request['id'],
								'result' => NULL,
								'error' => $e->getMessage()
								);
			
		}
		//echo 'yolo6';
		// output the response
		if (!empty($request['id'])) { // notifications don't want response
			//echo 'yolo4';
			header('content-type: text/javascript');
			
			// Origine en echo
			// Modifié pour permettre les renvois de valeur
			echo json_encode($response);
		}
		//echo 'yolo8';
		// finish
		return true;
	}
}
?>
