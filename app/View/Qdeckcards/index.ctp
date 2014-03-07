<?php //This lists profile -> deck -> list of cards?>
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body >
	<div class="container-fluid">
	
	<?php //List of Cards Section, add pre-scrollable and a height to div?>
	<div class="row">
		<div class="col-md-9">
		<h3>Cards</h3>
		<div class="table-responsive" style="overflow: auto;">
		<table class="table table-hover">
		<tr >
				<th>Type</th>
				<th>Question</th>
				<th>Answer</th>
		</tr>
		<?php foreach ($Qcards as $Qcard): ?>
			<tr >
				<td ><?php echo $Qcard['Qc']['cardType']; ?> </td>
				<td ><?php echo $Qcard['Qc']['question']; ?> </td>
				<td ><?php echo $Qcard['Qc']['answer']; ?> </td>
			</tr>
			<?php endforeach; ?>
			</table>
		</div>
			<?php unset($Qcard); ?>
		</div>

	<?php //Add Card Section?>


		<div class="col-md-3">
		<h3>Add Card
		<small>
		Deck: <?php echo $deckID ?> User:<?php echo $userID ?>
		</small>
		</h3>
		<?php
		$url = '/Qdeckcards/add/'.$deckID;
		echo $this->Form->create('Qcard', 
		array('url' => $url),
		array('inputDefaults' => array(
				'div' => array('class' => 'input-group input-group-sm'),
				'label' => array('class' => 'control-label'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => '')
		));
		echo $this->Form->input('cardType',array('class' => 'form-control', 'placeholder'=>'Card Type'));
		echo $this->Form->input('question',array('class' => 'form-control', 'placeholder'=>'Question'));
		echo $this->Form->input('answer',array('class' => 'form-control', 'placeholder'=>'Answer'));
		echo $this->Form->input('controllerName', array('type' => 'hidden'));
		echo $this->Form->input('groupID', array('type' => 'hidden'));
		echo $this->Form->end('Submit');
		?>
		<br/>
		<br/>
				<?php
				
					if($controllerName != 'Qgroupdecks')
					{
					echo $this->Html->link(
						'Back To Profile Decks', 
						array('controller' => 'qprofiledecks' ,'action' => 'index'),
						array('class' => 'signbutton')
						);
						}
					else
						{
						echo $this->Html->link(
						'Back To Group Decks', 
						array('controller' => $controllerName ,'action' => 'index', $groupID),
						array('class' => 'signbutton')
						);			
						}
						
						
				?>
				
			
		</div>
		
		
		
	</div>
	</div>
	
	
	
	
	</body>
</html>

