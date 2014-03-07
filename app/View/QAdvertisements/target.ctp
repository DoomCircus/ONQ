<!--
 *  Project : OnQ
 *  File : target.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : target.ctp allows an administrator to target demographics for an advertisement
 -->

<h1>Target Demographics</h1>
<div class="container-fluid" style="border-style:solid; border-width:1px">
	<?php
		echo $this->Form->create('Qadvertisement', array('action' => 'target'));
		echo $this->Form->input('advertisementID', array('type' => 'hidden')); 
	?>
	<table class="table-responsive" style="overflow: auto;">
		<tr>
			<td>
				<div style="margin:0px">Location</div>
				<!--<?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>-->
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px;">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Age <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Email Domain <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Gender <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Active Users <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->submit('Save Advertisement Targets'); ?>
	<?php echo $this->Form->end();?>
</div>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Advertisements',
		array('action' => 'index'),
		array( 'class' => 'signbutton')
	);
?>