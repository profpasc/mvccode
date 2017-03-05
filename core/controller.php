<?php 
class Controller
{
	public 	$cont;
	public 	$request;
	private $vars=array();
	public 	$layout='default';
	private $rendered=false;			
	public 	function __construct($request=null){
		if ($request) { $this->request=$request;} 
	}
	public function render($view){
		if ($this->rendered){ return false;}
		extract($this->vars);
		if (strpos($view,DS)===0) {$view=ROOT.DS.'view'.$view.'.php';}else { $view=ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';}
		ob_start();
		require $view;
		$content_for_layout=ob_get_clean();
		require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php';
		$this->rendered=true;		
	}
	public function set($key , $valeur=null){
		if ( is_array($key)) {$this->vars += $key;} else {$this->vars[$key] = $valeur;}
	}
	public function loadModel($name){ 
		$name=ucfirst($name);
		$file=ROOT.DS.'models'.DS.$name.'.php';
		require_once $file;
		if (!isset($this->$name)) {	$this->$name = new $name;}
	}
	public function e404($message){
		header("HTTP/1.0 404 Not Found");
		$this->set('message',$message);
		$this->render(DS.'errors'.DS.'404');
		//die();
	}
	public function request($action){
		$controller=ucfirst($this->cont);
		//die($controller);
		$controller.='Controller';
		require_once ROOT.DS.'controllers'.DS.$controller.'.php';
		$c= new $controller();
		return $c->$action();
	}
	public function getMenu(){
		$this->loadModel('Post');
		return $this->Post->find(array('condition'=>array('online'=>'1','type'=>lcfirst($this->cont))));
	}
	function redirect($url,$code=null){
		 if ($code==301) { 	header("HTTP/1.1 301 Moved Permanently"); } 
		 header("location: ".router::url($url));
	}
	
}
?>