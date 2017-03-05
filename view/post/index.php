<div class="page-header"><h1>le blog</h1></div>
	<?php foreach ($post as $k => $v): ?>
		<?php $t[]=$v->id; ?>
		<h2><?php echo $v->name; ?></h2>
		<?php echo $v->content; ?>
		<p><a href="<?php echo Router::url("post/view/id:$v->id/slug:$v->slug"); ?>">lire la suite &rarr;</a></p>
	<?php endforeach; ?>

<div class="pagination"	>
	<ul>
		<?php for ($i=1; $i <= $nbrePage; $i++): ?>
			<li <?php if($i==$pg){echo 'class="active"';}?>>
				<a href="<?php echo BASE_URL.'post'.DS.'index'.DS.$i; ?>" > <?php echo $i; ?></a>
			</li>
		<?php endfor;  ?> 
	</ul>

</div>
