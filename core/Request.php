<?php 
/**
* 
*/
class Request
{
	public $url; // url appellé par l'utilisateur
	public $prefix=false;
	public $data=false; 

	function __construct()
	{	if (isset($_SERVER['PATH_INFO'])) {
					$this->url=$_SERVER['PATH_INFO'];
		}else{
					$this->url=BASE_URL.'page'.DS.'view'.DS.'1';
			
		}
		
		if (!empty($_POST)) {
			$this->data = new stdClass();
			foreach ($_POST as $k => $v) {
				$this->data->$k = $v;
			}
			// debug($this->data);
		} 
		
	}
}

?>