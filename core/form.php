<?php
class Form{
	public $controller;
	
	public function __construct($controller)
	{
		$this->controller=$controller;

	}
	// on a utiliser le variable data sans instancier le class Form et passer le $controlller dans le construteur
	function input($name,$label,$option=array()){
		if (!isset($this->controller->request->data->$name)) {
			$value='';
		} else {
			$value=$this->controller->request->data->$name;
		}

		if ($label=='hidden') {
			return '<input type="hidden" name="'.$name.'"  value="'.$value.'" />';
		} 		 
		$html='<div class="form-search">
				 <label for="input'.$name.'" style="display=inline;">'.$label.'</label>
				 <div class="input">';
		$attr='';
		foreach ($option as $k => $v ) {
			$attr.=" $k=\"$v\"";
		}
		if(!isset($option['type'])){
			$html.='<input type="text" name="'.$name.'" id="input'.$name.'" value="'.$value.'"/>';
		}elseif ($option['type']=='textarea') {
			$html.='<textarea  name="'.$name.'" id="input'.$name.'" >'.$value.'</textarea>';
		}elseif ($option['type']=='checkbox') {
			// $value=($data->$name==1) ? 'checked' : '' ;
			$html.='<input type="hidden" name="'.$name.'" value="0"/>';
			$html.='<input type="checkbox" name="'.$name.'" value="1" '.(!empty($value) ? 'checked' : '').'/>';
		}									
		$html.='</div></div>';
		return $html;
	}
} ?>