<!DOCTYPE html>
<html>
	<head>
	<h1>
		<div class="loginform">
		
			<?php 
				echo "Welcome ";
				echo AuthComponent::user('userName');
				echo "!";
				echo $this->Session->flash('auth'); 
				echo $this->Form->create('Logout'); 
			?>
			<div style="width: 100%; display: table;">
				<div style="display: table-row">
					<div style="width: 90px; display: table-cell;">
						<?php 
							echo $this->Form->submit('LOGOUT', array('name'=>'submit1'));
						?>
					</div>
				</div>
			</div>
		</div>
	</h1>
	</head>
	<boby>
		<?php if ($authUser) { ?>
			<div class="container">
				<div class="row" >
					<div class="col-md-4">
						Sidebar content our mission statement is ......
						ssdnasjdnksandkdkasndsakdnkasndaskd
						dasdkajnsdkjsandjadnjkasdnasjdka
						wqeeqeqweqweqweqweqeqweqw

					</div>
					<div class="col-md-offet-8">
						Onq started out as a way to study on the go through repetition, using text messages to recieve questions
						and a score for the amount of correct answer it has since expanded into a website with various learning techniques
						incorperated. Having and a community backed way to generate content and rate content based on how accuerate the answer
						or how useful the question. 
					</div>
				</div>
			</div>
		<?php } ?>
	</body>
</html>
