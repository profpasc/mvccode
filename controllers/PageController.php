<?php 
/**
* 
*/
class PageController extends Controller
{
	public $cont='page';
	
	function view($id)
	{
		//if(!is_numeric($id)) die();
		$this->loadModel('post');

		$d['page']=$this->Post->findFirst(array('condition' =>array(
																	'online'=>'1', 'id'=>$id ,'type'=>'page')
												)
										);
		if (empty($d['page'])) {
			$this->e404(" page introuvable ");
		}
		 $this->set($d);
	}
	function index($id=1){

		$this->view($id);
	}
	
}?>