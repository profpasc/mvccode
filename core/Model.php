<?php
class Model
{
	static $connections=array();
	private $conf = 'default';
	private $table =false;
	private $db;
	public $id;
	public $primarykey='';
	public function __construct(   ){
		/// j'ai inicialise qques variable
		if ($this->table==false) {	$this->table=strtolower(get_class($this)).'s';	}
			
		$conf=Conf::$database[$this->conf];
		//j'ai connecte a la base
		if (isset(Model::$connections[$this->conf])) {
			$this->db=Model::$connections[$this->conf];
			//echo "reconnecter";
			return true;
		}
		try {
			$pdo=new PDO("mysql:host=".$conf['host'].";port=".$conf['port'].";dbname=".$conf['database'].";",
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8' ));
			 $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
			
			Model::$connections[$this->conf]=$pdo;
			$this->db=Model::$connections[$this->conf];
			} catch (PDOException $e) {
				if (Conf::$debug>=1) {
					die($e->getMessage()); 
				}else{	die('impossible de se deconnecter a la base de ');	}
			}
	}
	public function find($req)	{
		$sql='SELECT ';
		if (isset($req['fields'])) {
			if(is_array($req['fields'])){
				 $sql.=implode(',  ', $req['fields'] );/// car ils contienttableau avec seulement les valeir
			}else{
				$sql.=$req['fields']; 
			}
		}else{
			$sql.=' * ';
		}
		$sql.=' FROM '.$this->table.' ';
		if (isset($req['condition'])) {
			$sql.= ' WHERE ';
			if (!is_array($req['condition']) ) {
				$sql.=$req['condition'];
			} else {
				$cond= array();
				try {	foreach ($req['condition'] as $k=> $v) {///car ils contient tableau associative
								if(!is_numeric($v)){ $v= $this->db->quote($v,PDO::PARAM_STR); }						
								$cond[]=$k.'='.$v;
						}
						$sql .= implode(' AND ', $cond);
						//echo($sql);
					
				} catch (Exception $e) { die($e->getMessage()) ;	}
			}
		}
		if (isset($req['limit'])) {
				 $sql.=' limit '.$req['limit'] ;
			}
		 
		$pre = $this->db->prepare($sql);
		$pre->execute();
		return $pre->fetchAll(PDO::FETCH_OBJ);	
	} 
	public function findFirst($req)	{
		return current($this->find($req));
		//ou bien return $this->find($req)[0];
	}
	public function findCount($condition){
		$res=$this->findFirst( array('fields'=> 'COUNT(*) as count ','condition' =>$condition)); 
		return $res->count;
	}
	public function delete($id){
		$sql="delete from {$this->table} where {$this->primarykey}=$id; ";
		$this->db->query($sql);
	}
	public function save($data){
		 $key=$this->primarykey;

		 $fields=array();
		 // if(isset($data->$key)){
		 // 	$this->id=$data->$key;
		 // 	unset($data->$key);
		 // }
		 foreach ($data as $k => $v) {
		 	$fields[]=" $k=:$k";
		 	$d[":$k"]=$v;
		 }
		 if (isset($data->$key) && !empty($data->$key)) {
		 	$sql="update ".$this->table." set ".implode(',',$fields)." where ".$key."=:".$key;
		 	$this->id=$data->$key; 
		 	$sqlaction='update';
		 } else{
		 	$sql="insert into ".$this->table." set ".implode(',',$fields) ;
		 	$sqlaction='insert';
		 }
		 
		$pre = $this->db->prepare($sql);
		$pre->execute($d);
		if ($sqlaction='insert') {
			$this->id= $this->db->Lastinsertid();
		}
		return true; 
	}
}
?>