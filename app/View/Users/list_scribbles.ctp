<h1>My Scribbles</h1>
<table class="table table-striped">
	<thead>
		<th><?php echo $this->Paginator->sort('title');?></th>
		<th><?php echo $this->Paginator->sort('created');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
	</thead>
	<tbody>
		<?php foreach($data as $d):?>
			<tr>
				<td><?php echo $this->Html->link($d['Scribble']['title'], array('controller' => 'Scribbles', 'action' => 'view', $d['Scribble']['ukey']));?></td>
				<td><?php echo $d['Scribble']['created'];?></td>
				<td><?php echo $d['Scribble']['modified'];?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>

<?php if ($showPagination):?>
	<ul class="pagination">
	<?php
		echo $this->Paginator->prev('&laquo;', array(
				'tag' => 'li',
				'disabledTag' => 'a',
				'escape' => false
			), null, array(
				'class' => 'disabled',
				'disabledTag' => 'a',
				'escape' => false,
				'tag' => 'li'
			));

		echo $this->Paginator->numbers(array(
				'tag' => 'li',
				'currentClass' => 'active',
				'separator' => '',
				'currentTag' => 'a',
				'modulus' => 4,
				'ellipsis' => '...'
			));

		echo $this->Paginator->next('&raquo;', array(
				'tag' => 'li',
				'disabledTag' => 'a',
				'escape' => false
			), null, array(
				'class' => 'disabled',
				'disabledTag' => 'a',
				'escape' => false,
				'tag' => 'li'
			));
	?>
	</ul>
<?php endif;?>
