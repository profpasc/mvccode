<?php 
class PostController extends Controller
{
	public $cont='post';
	////////////////
	public function index($id=null){
		if ($id==null) { $id=1;}
		$perPage=1;
		$this->loadModel('Post');
		$condition=array('online'=>'1', 'type'=>'post');
		$d['post']=$this->Post->find(array('condition' =>$condition,'limit'=>($perPage*($id-1)).','.$perPage));
		if (empty($d['post'])) { $this->e404("page introuvable "); }
		$d['total']=$this->Post->findCount($condition);
		$d['nbrePage']=ceil($d['total']/$perPage);
		$d['pg']=$id;
		 $this->set($d);
	}
	function view($id,$slug=null){
			//if(!is_numeric($id)) die();
		$this->loadModel('post');
		$condition=array('online'=>'1', 'type'=>'post' , 'id'=>$id);
		$fields=array('id ','name','slug','content' );
		$d['post']=$this->Post->findFirst(array('condition' =>$condition,'fields'=>$fields));
		if (empty($d['post'])) {$this->e404("post introuvable ");}
		if ($slug!=$d['post']->slug) {
			$this->redirect( "post/view/id:$id/slug:".$d['post']->slug,301);
		} 
		 $this->set($d);
	}
	function admin_index($id=null){
		if ($id==null) { $id=1;}
		$perPage=12;
		$this->loadModel('Post');
		$condition=array('type'=>'post');
		$d['post']=$this->Post->find(array('condition' =>$condition,'limit'=>($perPage*($id-1)).','.$perPage));
		if (empty($d['post'])) { $this->e404("page introuvable "); }
		$d['total']=$this->Post->findCount($condition);
		$d['nbrePage']=ceil($d['total']/$perPage);
		$d['pg']=$id;
		$this->set($d);
	}
	function admin_edit($id=null){
		$this->loadModel('Post');
		$d['id']='';
		
		if($this->request->data){
			 $this->Post->save($this->request->data);
			 $id=$this->Post->id;
		}

		if(isset($id)){
			$this->request->data=$this->Post->findFirst(array('condition'=>array(''.$this->Post->primarykey.''=>$id)));
			$d['id']=$id;
		}
		$this->set($d);
	}
	function admin_delete($id){
		$this->loadModel('Post');
		//$this->Post->delete($id);

		$this->session->setflash('le contenu a bien ete supprimer ');

		$this->redirect('admin/post/index'); 
	}
}
 ?>