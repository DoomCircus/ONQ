<!-- app/View/Users/add.ctp -->
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
		<?php
			echo $this->Html->script(array('jquery','jquery-ui'));
			echo $this->Html->css('jquery-ui.css');
		?>
		<script>
			$(function() {
				   $("#datepicker").datepicker();
			});
		</script>
	</head>
	<body>
	
		<div class="users form" >
			<?php echo $this->Form->create('Qprofile', array('type'=>'file')); ?>
			<fieldset>
				<legend><?php echo __('Sign Up'); ?></legend>
				<?php 
					echo $this->Form->input('userName');
					echo $this->Form->input('password');
					echo $this->Form->input('firstName');
					echo $this->Form->input('lastName');
					echo $this->Form->input('emailAddress');
					echo $this->Form->input('phoneNumber');
					echo $this->Form->input('Qaddress.unitNumber');
					echo $this->Form->input('Qaddress.aptNumber');
					echo $this->Form->input('Qaddress.streetName');
					echo $this->Form->input('Qaddress.stateProvince');
					echo $this->Form->input('Qaddress.postalCode');
					echo $this->Form->input('maleFemale', array(
						'label'=>'Gender','options' => array('0' => 'male','1' => 'female')
					));
					echo $this->Form->input('dateOfBirth', array(
						'id'=>'datepicker','type'=>'text','name'=>'datepicker'
					));
					echo $this->Form->input('profilePic', array('required'=>false,'id'=>'profilePic','name'=>'profilePic', 'type'=>'file', 'accept'=>'image/*'));

				?>
			</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
		</div>
	</body>
</html>
