<!-- File: /app/View/QAdvertisments/edit.ctp -->

<h1>Edit Group</h1>
<?php
echo $this->Form->create('Qgroup');
echo $this->Form->input('groupID', array('type' => 'hidden'));
echo $this->Form->input('groupType');
echo $this->Form->input('groupTitle');
echo $this->Form->input('groupDescription');
echo $this->Form->input('Qgroup.privatePublic', array(
						'options' => array('0' => 'private','1' => 'public')
					));
echo $this->Form->end('Save Group');
?>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Groups', array('action' => 'index')
	);
?>