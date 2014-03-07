<!--
 *  Project : OnQ
 *  File : edit.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : edit.ctp allows the user to upload a different image for an advertisement
 -->

<h1>Edit Advertisement</h1>
<?php
	//Creates a new form for the advertisement that the user wants to edit
	echo $this->Form->create('Qadvertisement',
		array('type' => 'file',
			array('action' => 'edit', 'id' => $this->request->data['Qadvertisement']['advertisementID'])
		)
	);
	//Keeps the current advertisementID hidden in the page to pass to edit()
	echo $this->Form->input('advertisementID', array('type' => 'hidden'));
	//Restrict the users input to image file types
	echo $this->Form->input('Advertisement', array('id'=>'advertisement','type'=>'file','name'=>'advertisement','accept'=>'image/*'));
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