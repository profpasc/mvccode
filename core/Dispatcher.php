<?php 
class Dispatcher 
{
	var $request;
	static $pr=array();
	function __construct()
	{
		$this->request=new Request();
		Router::parse($this->request);
		$controller=$this->loadController();
		$action=$this->request->action;
		if($this->request->prefix){
			$action=$this->request->prefix.'_'.$action; 

		}
		// chercher seulement dans la pageControlller difference entre deux tables
		if(!in_array($action, array_diff(get_class_methods($controller), get_class_methods('Controller')) ))
		{ 
			$this->error('le controller n\'a pas de methode appeler '.$action,$controller);
		}else{
		call_user_func_array(array($controller,$action), $this->request->params);
		 // debug($controller);
		$controller->render($action);

		}
	}
	////

	function error($message,$controller){
		
		$controller->e404($message);
	}
	//////

	function loadController()
	{
		$name=ucfirst($this->request->controller).'Controller';
		$file= ROOT.DS.'controllers'.DS.$name.'.php';
		if (!file_exists($file)) {
			die('de quoi vous cherchez');
		}
		require $file;
		$controller= new $name($this->request);
		
		$controller->session = new Session();
		$controller->form =  new Form($controller);
		return $controller;

	}


}
 ?>