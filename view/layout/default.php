<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title_for_layout)? $title_for_layout :'mon site' ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'webroot'.DS.'css'.DS.'bootstrap.css'?>">
</head>
<body>




<div class="navbar" >
	<div class="navbar-inner" >
		<div class="container" >
			<h3 class="nav"><a href="#">mon site</a></h3>
			<ul class="nav">
				<li><a href="<?php echo router::url('post/index');?>">actualite</a></li>
				<li><a href="<?php echo BASE_URL.'page';?>">page</a></li>
				<?php $pagesMenu = $this->request('getMenu'); ?>
				<?php foreach ($pagesMenu as $p): ?>
					<li class="">
					<a href="<?php echo BASE_URL.$this->cont.DS.'view'.DS.$p->id; ?>" title="<?php echo $p->name; ?>">
					<?php echo $p->name ?>
					</a>
					</li>
				<?php endforeach ; ?>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<?php echo $this->session->flash(); ?>
	<?php echo  $content_for_layout;	?>
</div>
</body>
</html>