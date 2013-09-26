<h1>My Scribbles</h1>
<table class="table table-striped">
	<thead>
		<th>Title</th>
		<th>Created</th>
		<th>Modified</th>
	</thead>
	<tbody>
		<?php foreach($currentUser["Scribble"] as $scribble): ?>
			<tr>
				<td><?php echo $this->Html->link($scribble["title"], array('controller' => 'Scribbles', 'action' => 'view', $scribble["ukey"]));?></td>
				<td><?php echo $scribble["created"];?></td>
				<td><?php echo $scribble["modified"];?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
