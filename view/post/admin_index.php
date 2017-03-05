<div class="page-header">
	<h1><?php echo $total;  ?> article</h1>
</div>
 <table class="table">
 	<thead>
 		<tr>
 			<th>id</th>
 			<th>titre</th>
 			<th>action</th>
 		</tr>
 	</thead>
 	<tbody>
 		<?php foreach ($post as $k =>  $v ): ?>
 			<tr>
 				<td><?php echo $v->id; ?></td>
 				<td><?php echo $v->name; ?></td>
 				<td>
 					<a href="<?php echo router::url('admin/post/edit/'.$v->id); ?>">editer</a>
 					<a onclick="return confirm('voulez vous vraiment supprimer l\'article');" href="<?php echo router::url('admin/post/delete/'.$v->id); ?>">supprimer</a>
 				</td>
 			</tr>
 		<?php endforeach ?>
 	</tbody>
 </table>