<?php
	namespace Database;
	use PDO;

	/**
	*	Класс-шаблон для запросов
	*/

	class Request
	{
		public static $type = 'mysql';
		public static $dbname = 'test';
		public static $host = 'localhost';
		public static $user = 'root';
		public static $pass = '';
	 
		/**
		 *  Объект PDO.
		 */
		public static $dbh = null;
	 
		/**
		 * Statement Handle.
		 */
		public static $sth = null;
	 
		/**
		 * Выполняемый  SQL запрос.
		 */
		public static $query = '';
	 
		/**
		 * Подключение к БД
		 */
		public static function connection()
		{	
			if (!self::$dbh) {
				try {
					self::$dbh = new PDO(
						self::$type.':dbname='.self::$dbname.';host='.self::$host, 
						self::$user, 
						self::$pass, 
						array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
					);
					self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				} catch (PDOException $e) {
					exit('Ошибка соеденения с базой данных: ' . $e->getMessage());
				}
			}
	 
			return self::$dbh; 
		}
	 
		/**
		 * Добавление в таблицу, в случаи успеха вернет вставленный ID, иначе 0.
		 */
		public static function insert($query, $param = array())
		{
			self::$sth = self::connection()->prepare($query);
			return (self::$sth->execute((array) $param)) ? self::connection()->lastInsertId() : 0;
		}
		
		/**
		 * Выполнение запроса.
		 */
		public static function query($query, $param = array())
		{
			self::$sth = self::connection()->prepare($query);
			return self::$sth->execute((array) $param);
		}
		
		/**
		 * Получение строки из таблицы.
		 */
		public static function where($query, $param = array())
		{
			self::$sth = self::connection()->prepare($query);
			self::$sth->execute((array) $param);
			return self::$sth->fetch(PDO::FETCH_ASSOC);		
		}
		
		/**
		 * Получение всех строк из таблицы.
		 */
		public static function all($query, $param = array())
		{
			self::$sth = self::connection()->prepare($query);
			self::$sth->execute((array) $param);
			return self::$sth->fetchAll(PDO::FETCH_ASSOC);	
		}
		
		/**
		 * Получение значения.
		 */
		public static function select($query, $param = array(), $default = null)
		{
			$result = self::where($query, $param);
			if (!empty($result)) $result = array_shift($result);
	 
			return (empty($result)) ? $default : $result;	
		}
		
		/**
		 * Получение столбца таблицы.
		 */
		public static function column($query, $param = array())
		{
			self::$sth = self::connection()->prepare($query);
			self::$sth->execute((array) $param);
			return self::$sth->fetchAll(PDO::FETCH_COLUMN);	
		}
	}

?>