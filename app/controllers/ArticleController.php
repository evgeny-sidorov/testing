<?php 
	namespace App\Controllers;
	use App\Models\Article;
	/**
	* Контроллер для статей
	*/
	class ArticleController
	{
 
		public function show($category='')
		{
			$article = new Article();
			var_dump( $article->get($category)); ///////
			return $article->get($category);
		}
	}
?>