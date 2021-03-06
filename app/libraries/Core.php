<?php

	//core app class
	// defining the url
	class Core {
		protected $currentController = 'Pages';
		protected $currentMethod = 'index';
		protected $params = [];

		public function __construct(){
			$url = $this->getUrl();
			// look in 'controllers' for first value, ucword will  capitalize first letter
			if (file_exists('../app/controllers/' . ucwords($url[0]). '.php')) {
				$this->currentController = ucwords($url[0]);
				unset($url[0]);
			}
			require_once '../app/controllers/'. $this->currentController . '.php';
			$this->currentController = new $this->currentController;

			//checking the second part of the url
			if (isset($url[1])) {
				if (method_exists($this->currentController, $url[1])) {
					$this->currentMethod = $url[1];
					unset($url[1]);
				}
			}

			//Get parameter
			$this->params = $url ? array_values($url) : [];

			//call a callback with array of params
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		}

		public function getUrl(){
			if (isset($_GET['url'])) {
				$url = rtrim($_GET['url'], '/');
				//allows you to filter variable as strings
				$url = filter_var($url, FILTER_SANITIZE_URL);
				// explode helps brealing it into an array
				$url = explode('/', $url);
				return $url;
			}
		}
	}