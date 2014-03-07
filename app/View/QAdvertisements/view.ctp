<!--
 *  Project : OnQ
 *  File : view.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 20, 2014
 *  Description : view.ctp allows the user to view a specific advertisement
 -->

<h1><?php echo 'Details of Ad: '.h($Qadvertisement['Qadvertisement']['advertisementID']); ?></h1>

<p>
	<?php 
		$image = file_get_contents($Qadvertisement['Qadvertisement']['advertisement']); //File path from DB
		$pathInPieces = explode('/', $Qadvertisement['Qadvertisement']['advertisement']); //Break path
		$fileName = $pathInPieces[count($pathInPieces)-1]; //Grab file name + extension
		header('Content-Type: image/*');
		echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="'.$fileName.'">';
	?>
</p>

<?php
	echo $this->Form->postLink(
		'Delete',
		array('action' => 'delete', $Qadvertisement['Qadvertisement']['advertisementID']),
		array( 'class' => 'signbutton',
			'confirm' => 'Are you sure?')
	);
?>
<?php
	echo $this->Html->link(
		'Edit',
		array('action' => 'edit', $Qadvertisement['Qadvertisement']['advertisementID']),
		array( 'class' => 'signbutton')
	);
?>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Advertisements',
		array('action' => 'index'),
		array( 'class' => 'signbutton')
	);
?>