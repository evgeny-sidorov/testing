<?php
	/**
	* Класс маршрутизации
	*/
	class Route
	{
		// Массив для хранения url => функция
		private static $routes = array();
	   
	    // Запрет создания и копирования статического объекта
		private function __construct() {}
		private function __clone() {}
	   
	   
	    // Метод принимает шаблон url-адреса и функцию
	    public static function route($pattern, $callback)
	    {
	        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
	        self::$routes[$pattern] = $callback;
	    }
	   
	   
	    // Метод проверяет запрошенный $url на соответствие адресам в массиве $routes
	    public static function execute($url)
	    {
	        foreach (self::$routes as $pattern => $callback) {

	            if (preg_match($pattern, $url, $params)) {
	                // Если соответствие найдено, удаляет первый элемент из массива $params
	                array_shift($params);
	                return call_user_func_array($callback, array_values($params));
	            }

	        }
	        
	    }
	}
?>