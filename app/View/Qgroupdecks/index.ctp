<?php
//This lists group -> list of decks
?>

<!DOCTYPE html>
<html>
	<head>
	<h1>
		
		</h1>
	</head>
	<body>

		<h1>Group <?php echo $groupID ?> Decks</h1>
		<p><?php echo $this->Html->link('Add Deck', array('action' => 'add',$groupID),array('class'=>'signbutton')); ?></p>
		<table class="table">
		<tr >
				<th>Type</th>
				<th>Title</th>
				<th>Description</th>
				<th>Rating</th>
				<th>Date Created</th>			
				<th>Privacy</th>
				<th>Actions</th>
				
		</tr>
		<?php foreach ($Qdecks as $Qdeck): ?>
			<tr >
				<td ><?php echo $Qdeck['Qd']['deckType']; ?> </td>
				<td><?php echo $Qdeck['Qd']['title']; ?> </td>
				<td><?php echo $Qdeck['Qd']['description']; ?> </td>
				<td><?php echo $Qdeck['Qd']['rating']; ?> </td>
				<td><?php echo $Qdeck['Qd']['created']; ?></td>		
					<?php if($Qdeck['Qd']['privatePublic'] == 0) { ?>
					<td>  Private</td>
					<?php }elseif ($Qdeck['Qd']['privatePublic'] == 1){  ?>
					<td>  Public</td>
					<?php } ?>
				</td>
				<td>
					<?php
						echo $this->Html->link(
							'View Details', 
							array('controller' => 'qdeckcards' ,'action' => 'view', $Qdeck['Qd']['deckID'], $groupID),
							array('class' => 'signbutton')
							);
					?>	
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $Qdeck['Qd']['deckID'], $groupID),
							array( 'class' => 'signbutton'),
							array('confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', 
							array('controller' => 'qgroupdecks' ,'action' => 'edit', $Qdeck['Qd']['deckID'], $groupID),
							array('class' => 'signbutton')

						);
					?>						
				<?php
					echo $this->Html->link(
						'Cards', 
						array('controller' => 'qdeckcards' ,'action' => 'index', $Qdeck['Qd']['deckID'], $groupID),
						array('class' => 'signbutton')
						);
				?>	
				

				</td>
			</tr>
			<?php endforeach; ?>
			</table>
			<?php unset($Qdeck); ?>

	</body>
</html>

