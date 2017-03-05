<?php 
class Session {

	PUBLIC function __construct(){
		if(!isset($_SESSION)){
			session_start();
		}
	}
	public function setflash($message,$type='success'){
		$_SESSION['flash'] = array(
			'message' => $message , 
			'type'=> $type
			);

	}
	public function flash(){
		$html=''; 
		if(isset($_SESSION['flash']['message'])){
			$html= '<div class="navbar-'.$_SESSION['flash']['type'].'" ><p>'. $_SESSION['flash']['message'].'</p> </div>';	
			$_SESSION['flash']=array();
			return $html;
		}

	}
}?>