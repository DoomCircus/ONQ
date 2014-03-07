<!-- app/View/Qprofiles/add.ctp -->
<!DOCTYPE html>
<html>
	<head>
		<style>
			
			input, textarea {
				clear: both;
				background-color: #b6cef7;
				border-color: #1160e5;
				font-size: 60%;
				font-family: "frutiger linotype", "lucida grande", "verdana", sans-serif;
				padding: 1%;
				width:40%;
				vertical-align:top;
			}
		</style>
	</head>
	<body>
		<div class="Qprofile form">
		<?php echo $this->Form->create('Qprofile'); ?>
			<fieldset>
				<legend><?php echo __('Add User'); ?></legend>
				<?php echo $this->Form->input('userName');
				echo $this->Form->input('password');
				echo $this->Form->input('emailAddress');
				echo $this->Form->input('role', array(
					'options' => array('admin' => 'Admin', 'user' => 'General User')
				));
			?>
			</fieldset>
		<?php echo $this->Form->end(__('ADD')); ?>
		</div>
	</body>
</html>