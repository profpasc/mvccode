<?php 
/**
* 
*/
class Conf
{
	static $debug=1;
	
	static $database = array(
					'default' => array('host' => 'localhost',
										'port'=>'8889',
										'database'=>'tuto',
										'login'=>'kamal',
										'password'=>'toor' )
					);
}


//router::connect( '/','post/index');
router::prefix('cockpit','admin'); 
router::connect( 'post/:slug-:id','post/view/id:([0-9]+)/slug:([a-z0-9_]+)');
router::connect( 'blog/:action','post/:action');
 ?>