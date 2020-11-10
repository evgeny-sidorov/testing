<?php
	namespace App\Models;
	use Database\Request;
	/**
	* Модель статей
	*/
	class Article
	{

		public function get($category)
		{	
			if( preg_match("/^[a-zA-Z0-9\-_]+$/", $category) ) $article = Request::all('SELECT * FROM `articles` WHERE `category` = :category LIMIT 5 ', array('category' => $category) ); //Если все символы допустимы выполяентся запрос

			$result = $article ? json_encode($article) : 'end'; // Если статьи есть, выводятся в Json, если нет - вывод end
			return $result;
		}

	}
?>