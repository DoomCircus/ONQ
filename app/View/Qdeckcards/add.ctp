<h1>Add Deck</h1>
<?php echo $this->Form->create('Qprofiledeck'); ?>
    <fieldset>
        <legend><?php echo __('Create a Deck'); ?></legend>
		<?php 
		echo $this->Form->input('Qdeck.deckType',array('class' => 'form-control'));
		echo $this->Form->input('Qdeck.title',array('class' => 'form-control'));
		echo $this->Form->input('Qdeck.description',array('class' => 'form-control'));
		echo $this->Form->input('Qdeck.privatePublic', array('class'=>'form-control','options' => array('0' => 'Private', '1' => 'Public')));	?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>