<div class="page-header">
	<h1>editer un  article</h1>
</div>
<!-- <?php debug($this->request->data); ?> -->
<form action="<?php echo router::url('admin/post/edit/'.$id); ?>" method="post">
	<?php echo $this->form->input( 'name','titre') ?>
	<?php echo $this->form->input('id','hidden') ?>
	<?php echo $this->form->input('slug','URL') ?>
	<?php echo $this->form->input('content','contenu',array('type'=>'textarea')) ?>
	<?php echo $this->form->input('online','En ligne',array('type'=>'checkbox')) ?>
	<div class="action">
		<input type="submit" class="btn-primary" />
	</div>
</form>