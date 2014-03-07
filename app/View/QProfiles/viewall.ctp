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
							echo $this->Html->link("LOGOUT", array('controller' => 'Qprofiles','action'=> 'logout'), array( 'class' => 'signbutton'))
								//echo $this->Form->submit('SIGN UP', array('name'=>'submit2'));
						?>
						</div>
					</div>
				</div>
		</div>
	</h1>
	</head>
	<body>
		<div class="myTable" >
                <table >
                    <tr>
                        <td>
                            Profile ID
                        </td>
                        <td >
                            User Name
                        </td>
						<td >
                            Role
                        </td>
						<td >
                            Active
                        </td>
						<td >
                            Action
                        </td>
                    </tr>
					<?php foreach ($profiles as $profile): ?>
                    <tr>
                        <td >
                            <?php echo $profile['Qprofile']['profileID']; ?>
                        </td>
                        <td>
                            <?php echo $profile['Qprofile']['userName']; ?>
                        </td>
						<td>
                            <?php echo $profile['Qprofile']['role']; ?>
                        </td>
						<td>
                            <?php 
							if($profile['Qprofile']['isActive'] == 1){
								echo '<img src="../img/checkmark.png" border=0>';
								echo $this->Form->postLink(
									'De-Activate',
									array('action' => 'deactivate', $profile['Qprofile']['profileID']),
									array('confirm' => 'Are you sure?')
								);
							}
							else{
								echo '<img src="../img/x.png" border=0>';
								echo $this->Form->postLink(
									'Activate',
									array('action' => 'activate', $profile['Qprofile']['profileID']),
									array('confirm' => 'Are you sure?')
								);
							}
							?>
                        </td>
                        <td>
                           <?php
								
								echo $this->Html->link(
									'Edit', array('action' => 'edit', $profile['Qprofile']['profileID'])
								);
							?>
                        </td>
                    </tr>
                  <?php endforeach; ?>
                </table>
            </div>
		
	</body>
</html>



