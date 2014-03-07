<!-- File: /app/View/Posts/index.ctp -->
<!DOCTYPE html>
<html>
	<head>
	<h1>
		
		</h1>
	</head>
	<boby>
		<h1>Groups</h1>
		<p><?php echo $this->Html->link('Add Groups', array('action' => 'add'),array('class'=>'signbutton')); ?></p>
		<p><?php echo $this->Html->link("Join Group", array('controller' => 'Qprofilegroups','action'=> 'join'), array( 'class' => 'signbutton')); ?></p>
	
	<br/>
	<br/>

		
			

		<!-- Here's where we loop through our $posts array, printing out post info -->
	<?php $mycounter = 0?>
			<?php foreach ($Qgroups as $Qgroup): ?>
			
			<br/>
			<div >
			<!--  <a href="google.com"><span>-->
			<table class="myTable">
			<tr >
			<th></th>
				<th>Type</th>
				<th>Title</th>
				<th>Description</th>
				<th>Date Created</th>
				<th>Privacy Setting</th>
				<th>Group Code</th>
				<th></th>
				
			</tr>
			<tr >
				<td ><span class="badge badge-info"><?php echo $count[$mycounter][0][0]['COUNT(*)']; ?></span></td >
					<?php $mycounter = $mycounter  + 1; ?>
				<td ><?php echo $Qgroup['QgroupJoin']['groupType']; ?> </td>
				<td><?php echo $Qgroup['QgroupJoin']['groupTitle']; ?> </td>
				<td><?php echo $Qgroup['QgroupJoin']['groupDescription']; ?> </td>
				<td>
					<?php echo $Qgroup['QgroupJoin']['lastModified']; ?>
					
				</td>
									
					<?php if($Qgroup['QgroupJoin']['privatePublic'] == 0) { ?>
					<td>  private</td>
					<?php }elseif ($Qgroup['QgroupJoin']['privatePublic'] == 1){  ?>
					<td>  public</td>
					<?php } ?>
					
								
				<td>
				<?php 
				if($Qgroup['Qprofilegroup']['owner'] == 1)
				{
					
					echo $Qgroup['QgroupJoin']['groupCode']; 
					
				}
				?>
				
				</td>
				<td>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $Qgroup['Qprofilegroup']['groupID']),
							array( 'class' => 'signbutton'),
							array('confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $Qgroup['Qprofilegroup']['groupID']),
							array( 'class' => 'signbutton')
						);
					?>
					<?php
						echo $this->Html->link(
							'Decks', array( 'controller' => 'Qgroupdecks','action' => 'index', $Qgroup['Qprofilegroup']['groupID']),
							array( 'class' => 'signbutton')
						);
					?>
				</td>
			</tr>
			
			</table>
		
			<!-- </span></a> -->
			</div>
			
			<?php endforeach; ?>

		
		
	</body>
</html>

