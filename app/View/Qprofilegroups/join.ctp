<!-- app/View/Qprofiles/add.ctp -->
<div class="Qgroup form">
<?php echo $this->Form->create('Qprofilegroup'); ?>
    <fieldset>
        <legend><?php echo __('Join a Group'); ?></legend>
        <?php 
		echo $this->Form->input('code');
		?>
    </fieldset>
<?php echo $this->Form->end(__('join')); ?>
</div>