<!--
 *  Project : OnQ
 *  File : index.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 20, 2014
 *  Description : index.ctp displays all advertisements in the database
 -->
 
<!DOCTYPE html>
<html>
	<head>
	</head>
	<boby>
		<h1>Advertisements</h1>
		<p><?php echo $this->Html->link('Add Advertisement', array('action' => 'add'), array( 'class' => 'signbutton')); ?></p>
		<br/>
		<br/>
		<br/>
		<table class="myTable">
			<tr>
				<th>Id</th>
				<th>Advertisement</th>
			</tr>

		<!-- Here's where we loop through our $qadvertisements array, printing out advertisement info -->

			<?php foreach ($Qadvertisements as $qad): ?>
			<tr>
				<td><?php echo $qad['Qadvertisement']['advertisementID']; ?></td>
				<td>
					<?php
						$image = file_get_contents($qad['Qadvertisement']['advertisement']); //File path from DB
						$pathInPieces = explode('/', $qad['Qadvertisement']['advertisement']); //Break path
						$fileName = $pathInPieces[count($pathInPieces)-1]; //Grab file name + extension
						header('Content-Type: image/*');
						echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="'.$fileName.'" height="100" width="100">';
						//echo '<a href="Qadvertisements/View/'.$qad['Qadvertisement']['advertisementID'].'"><img src="data:image/jpeg;base64,'
						//	. base64_encode($image) . '" alt="'.$fileName.'" height="100" width="100"></a>';
					?>
				</td>
				<td>
					<?php
						echo $this->Html->link(
							'View Details', array('action' => 'view', $qad['Qadvertisement']['advertisementID']),
							array( 'class' => 'signbutton')
						);
					?>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $qad['Qadvertisement']['advertisementID']),
							array('class' => 'signbutton',
								'confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $qad['Qadvertisement']['advertisementID']),
							array( 'class' => 'signbutton')
						);
					?>
					<?php
						/*echo $this->Html->link(
							'Target Users', array('action' => 'target', $qad['Qadvertisement']['advertisementID']),
							array( 'class' => 'signbutton')
						);*/
					?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</body>
</html>

