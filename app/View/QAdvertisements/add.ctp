<!--
 *  Project : OnQ
 *  File : add.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : add.ctp allows the user to upload a new advertisement
 -->

<h1>Add Advertisement</h1>

<?php
	echo $this->Form->create('Qadvertisement', array('action' => 'add', 'type' => 'file'));
	//Restricts the users input to image file types
	echo $this->Form->input('Advertisement', array('id'=>'advertisement','name'=>'advertisement', 'type'=>'file', 'accept'=>'image/*'));
	echo $this->Form->submit('Save Advertisement');
	echo $this->Form->end();
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