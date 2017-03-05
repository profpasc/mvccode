<?php  class Router {
 	static $routes=array();
 	static $prefixes= array();
 	static $c=0;
 	static function prefix($url,$prefix){
		 self::$prefixes[$url]=$prefix;

 	}
 	static  function parse( $request ){
 		$url=trim($request->url ,'/');
 		// echo "$url    ";
 		$test=false;
 			// debug(self::$routes);
		foreach (self::$routes as $v) {
			if(preg_match($v['catcher'], $url,$match)){	
				$test=true;
			}
		}
 		if ($test) {
		$url=self::unurl($url);
		 		foreach (self::$routes as $v) {
					if(preg_match($v['origin'], $url,$match)){	
						// debug($match);
						$request->controller=$v['controller'];
						$request->action = (isset($match['action'])) ? $match['action'] : $v['action'];
						$request->params = array();
					if (!isset($v['params']) ){
						// $request->params = array(1);
					}	else{

						foreach ($v['params'] as $k => $v) {
								//$request->params[$k]=$v;expression reguliere
						 		$request->params[$k]=$match[$k];// valeurs recuperer
						}
					}
						// if(!empty($match['args'])){
						// 	$request->params += explode('/', trim($match['args'],'/'));
						// }
						return $request;
				 	}
		 		}
 		} 
 		$params=explode('/', $url);
 		if(in_array($params[0],array_keys(self::$prefixes))){
 			$request->prefix= self::$prefixes[$params[0]];
 			array_shift($params);
 		} 
 		// debug($params);
 		$request->controller =  $params[0];
 		$request->action = isset($params[1])? $params[1] : 'index';
 		$request->params =(!empty(array_slice($params, 2))) ? array_slice($params, 2) : array();
 		return true;
 	}
//                                                 router::connect( 'blog/:action','post/:action');
 	static function connect($redir,$urlorigin){//router::connect( 'post/:slug-:id','post/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
 		self::$c+=1;
 		$r=array();
		$r['origin']=str_replace(':action', '(?P<action>[a-z0-9-_]+)', $urlorigin);
 		//faire un drappaux
		$r['origin']=preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:(?P<${1}>${2})', $r['origin']);
		//finalisee l'expression reguliere
		$r['origin']='/^'.str_replace('/', '\/', $r['origin']).'/';
	//	debug($r);
		$r['params']=array();
		$params=explode('/', $urlorigin );
		foreach ($params as $k => $v) {
			if (strpos($v, ':')) {
				$p=explode(':', $v);
				$r['params'][$p[0]]=$p[1];
			}else{
				if ($k===0) {
					$r['controller']=$v;
				}elseif ($k===1) {
					$r['action']=$v;
				}
			}
		}
		$r['redir']=$redir;
		$r['catcher']=$r['redir'];
		$r['catcher']=str_replace(':action', '(?P<action>[a-z0-9-_]+)', $r['catcher']);
		foreach ($r['params'] as $k => $v) {
			$r['catcher']= str_replace(":$k","(?P<$k>$v)", $r['catcher']);
		}
 		$r['catcher']='/^'.str_replace('/', '\/', $r['catcher']).'/';
 		  // debug($r);
 		self::$routes[]=$r;
 	} 	
//  	router::connect( 'post/:slug-:id','post/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
// router::connect( 'blog/:action','post/:action');str_replace(':action', '(?P<action>[a-z0-9-_]+)', $urlorigin);
	static function  url($url){
		foreach (self::$routes as $v) {
			// debug($v['origin']);
			// debug($url);
			if(preg_match($v['origin'], $url,$match)){	
				// debug('url===='.$url);
				// debug($match);
				foreach ($match as $k=> $w) {
					if(!is_numeric($k)){
						$v['redir']=str_replace(":$k", $w, $v['redir']);
					}
				}
				$url=$v['redir'];//ici base_url='/'
			}
		}	
		// debug($url) ;
		foreach (self::$prefixes as $k => $v) {
			if (strpos($url,$v)===0) {
					$url=str_replace($v,$k,$url);
				}
		}		
		return BASE_URL.$url;
	}
	/////////
	static function unurl($url){
		$url2=$url;
		for ($i=self::$c; $i >=1 ; $i--) {
			$v=self::$routes[$i-1] ;
			if(preg_match($v['catcher'], $url2,$match)){
				// debug($match);
				if(isset($match['action'])){
					$url2=$v['controller'].'/'.$match['action'];
				}else{
					$url2=$v['controller'].'/'.$v['action'].'/id:'.$match['id'].'/slug:'.$match['slug'];
				}
				$url2=$url2;//ici base_url='/'
				
			}
		}
		return $url2;
	}
} 
?>