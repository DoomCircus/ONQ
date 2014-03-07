<!DOCTYPE html>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>	
		<script src="js/bootstrap.min.js"></script>
		<script>
		  $(document).ready(function(){
			$('.carousel').carousel({
			
			interval: 4000
			});
		  });
		</script>	
	<h1>
		<div class="loginform">
		<?php if (!$authUser) { 
			echo $this->Session->flash('auth'); 
			echo $this->Form->create('Qprofile'); 
			echo $this->Form->input('username');
			echo $this->Form->input('password');
			?>
			<div style="width: 100%; display: table;">
				<div style="display: table-row">
					<div style="width: 90px; display: table-cell;">
						<?php 
							echo $this->Form->submit('LOGIN', array('name'=>'submit1'));
						?>
					</div>
					<div style="display: table-cell;">
						<?php 
							echo $this->Html->link("SIGN UP", array('controller' => 'Qprofiles','action'=> 'register'), array( 'class' => 'signbutton'))
							//echo $this->Form->submit('SIGN UP', array('name'=>'submit2'));
						?>
					</div
				</div>
			</div>
		</div>				
	</h1>
	</head>
	<body>
		<div class="container">
			<div id="this-carousel-id" class="carousel slide">
				<div class="carousel-inner">
					<div class="item active">
					  <img src="http://placehold.it/1200x480" alt="" />
					  <div class="carousel-caption">
						<p><h2>Caption 1</h2></p>
					  </div>
					</div>
					<div class="item">
					  <img src="http://placehold.it/1200x480" alt="" />
					  <div class="carousel-caption">
						<p><h2>Caption 2</h2></p>
					  </div>
					</div>
					<div class="item">
					  <img src="http://placehold.it/1200x480" alt="" />
					  <div class="carousel-caption">
						<p><h2>Caption 3</h2></p>
					  </div>
				</div>
			  </div>
				<a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
			</div>
			<div class="row">
			<div class="col-md-12">
					<?php
						//echo $this->Html->image('../img/head.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
			</div>
			<br/>
				<div class="row" >
					<div class="col-md-4">
					<?php
						echo $this->Html->image('../img/studentindex.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
					
					<div class="col-md-8 well">
						<----- Face . Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Duis dictum viverra magna at rutrum. Vestibulum eu neque et nisl egestas rhoncus. 
						Nullam iaculis bibendum vehicula. Duis a sagittis nibh, ac commodo urna. Suspendisse 
						quis lorem ut libero interdum fermentum. Donec quis purus elit. Pellentesque eget aliquam 
						turpis. Morbi nec scelerisque purus. Mauris ut tristique eros. Quisque 
						scelerisque, felis quis dapibus pulvinar, purus elit malesuada dui,
						 quis iaculis tortor enim sit amet mauris.   
						 
						 						Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Duis dictum viverra magna at rutrum. Vestibulum eu neque et nisl egestas rhoncus. 
						Nullam iaculis bibendum vehicula. Duis a sagittis nibh, ac commodo urna. Suspendisse 
						quis lorem ut libero interdum fermentum. Donec quis purus elit. Pellentesque eget aliquam 
						turpis. Morbi nec scelerisque purus. Mauris ut tristique eros. Quisque 
						scelerisque, felis quis dapibus pulvinar, purus elit malesuada dui,
						 quis iaculis tortor enim sit amet mauris. 	scelerisque, felis quis dapibus pulvinar,
						 purus elit malesuada dui,
						 quis iaculis tortor enim sit amet mauris. 
				
					</div>
				</div>
				<br/>
				<div class="row" >
					<div class="col-md-8 well pull-left">
						ONQ And Android make luv. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Duis dictum viverra magna at rutrum. Vestibulum eu neque et nisl egestas rhoncus. 
						Nullam iaculis bibendum vehicula. Duis a sagittis nibh, ac commodo urna. Suspendisse 
						quis lorem ut libero interdum fermentum. Donec quis purus elit. Pellentesque eget aliquam 
						turpis. Morbi nec scelerisque purus. Mauris ut tristique eros. Quisque 
						scelerisque, felis quis dapibus pulvinar, purus elit malesuada dui,
						 quis iaculis tortor enim sit amet mauris.   
						 
						 						Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Duis dictum viverra magna at rutrum. Vestibulum eu neque et nisl egestas rhoncus. 
						Nullam iaculis bibendum vehicula. Duis a sagittis nibh, ac commodo urna. Suspendisse 
						quis lorem ut libero interdum fermentum. Donec quis purus elit. Pellentesque eget aliquam 
						turpis. Morbi nec scelerisque purus. Mauris ut tristique eros. Quisque 

						 quis iaculis tortor enim sit amet mauris. 	scelerisque, felis quis dapibus pulvinar,
					</div>
					<div class="col-md-4 pull-right">
					<?php
						echo $this->Html->image('../img/onqdroid.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
				</div>
				<br/>
				<br/>
				<div class="row">
				<div class="col-md-2 col-md-offset-5">
				<h2 class="center">The Team</h2>
				<br/>
			</div>
		</div>
		<div class="row " >
			<div class="col-md-3">  
			<?php
				echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
			
			</div>
			
			<div class="col-md-3 ">
			<?php
				echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
			</div>	
			
			<div class="col-md-3 ">
			<?php
				echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
			</div>
			
			<div class="col-md-3">
			<?php
				echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
			</div>
		</div>
		<div class="row " >
			<div class="col-md-3 well">  
			Darryl
			</div>
			<div class="col-md-3 well"> 
			Francisco
			</div>
			<div class="col-md-3 well">  
			Francis
			</div>
			<div class="col-md-3 well">  
			Jose
			</div>
		</div>
	</div>
	<?php } ?>
	</div>
		
	</body>
</html>
