<!-- app/View/Qprofiles/add.ctp -->
<div class="Qgroup form">
<?php echo $this->Form->create('Qprofilegroup'); ?>
    <fieldset>
        <legend><?php echo __('Create a Group'); ?></legend>
        <?php 
		echo $this->Form->input('Qgroup.groupType');
		echo $this->Form->input('Qgroup.groupTitle');
		echo $this->Form->input('Qgroup.groupDescription');
		echo $this->Form->input('Qgroup.privatePublic', array(
						'options' => array('0' => 'private','1' => 'public')
					));
		?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>