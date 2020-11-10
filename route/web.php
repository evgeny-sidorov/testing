<?php
	use App\Controllers\ArticleController;

	//Маршруты

	Route::route('/articles', function() {
		$_POST['category'] = 'category1'; //AJAX
		$article = new ArticleController();
		$article->show($_POST['category']);
		
	});

	// Старт роута
	Route::execute($_SERVER['REQUEST_URI']); 
?>