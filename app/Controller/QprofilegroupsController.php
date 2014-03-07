<?php 
class QprofilegroupsController extends AppController {

	public $uses = array(
        'Qgroup','Qprofile','Qprofilegroup','Qachievement','Qgroupdeck'
    );
	
    public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		$this->loadModel('Qgroup','Qprofile','Qprofilegroup','Qachievement');
		if($this->Auth->user('role')=='user')
		{
			$this->Auth->allow('view','edit','index','add','join');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login');
		}
		 // Basic setup
		$this->Auth->authenticate = array('Form');

		// Pass settings in
		$this->Auth->authenticate = array(
									'Basic' => array('userModel' => 'Qgroup'),
									'Form' => array('userModel' => 'Qgroup')
		);
    }
	



	
	public function logout() 
	{
		return $this->redirect($this->Auth->logout());
	}

     public function index() {  
       
	  $this->Qprofilegroup->recursive = -1;
	  
	 //  $this->set('Qprofilegroups',
	 
	$Qgroups =	   $this->Qprofilegroup->find('all',array(
	 'joins' => array(
        array(
            'table' => 'Qgroups',
            'alias' => 'QgroupJoin',
            'type' => 'INNER',
            'conditions' => array(
                'QgroupJoin.groupID = Qprofilegroup.groupID'
            )
        )
    ),
    'conditions' => array(
        'Qprofilegroup.profileID' => $this->Auth->user('profileID')
    ),
    'fields' => array('QgroupJoin.*','Qprofilegroup.*')
	));
	 $count;
	foreach($Qgroups as $q)
	{
    $count[] = $this->Qgroup->procedureDecks($q['QgroupJoin']['groupID']);
	}
	
	//debug($Qgroups);
	//debug($count);
       $this->set('Qgroups', $Qgroups);
	   $this->set('count', $count);
    }  
  
   
  function generateCode($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
	}
	
    public function add() {  
  
   if ($this->request->is('post')) {
       
            $this->Qprofilegroup->create();
		//	debug( 'adding');
			$this->request->data['Qprofilegroup']['profileID'] = $this->Auth->user('profileID');
			$this->request->data['Qprofilegroup']['owner'] = 1;
			$this->request->data['Qgroup']['groupCode'] = $this->generateCode($length = 10);
			$this->request->data['Qgroup']['lastModified'] = date("Y-m-d H:i:s");
            if ($this->Qprofilegroup->saveAll($this->request->data, array('deep' => true))) {
                $this->Session->setFlash(__('The group has been created'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The group could not be created. Please, try again.')
            );

    } 
	}


	
	function findGroupCodeID($code)
	{
	 $this->Qprofilegroup->recursive = -1;
	  
		$Qgroups =$this->Qprofilegroup->find('all',array(
	 'joins' => array(
        array(
            'table' => 'Qgroups',
            'alias' => 'QgroupJoin',
            'type' => 'INNER',
            'conditions' => array(
                'QgroupJoin.groupID = Qprofilegroup.groupID'
            )
        )
    ),
    'conditions' => array(
        'QgroupJoin.groupCode' => $code
    ),
    'fields' => array('QgroupJoin.*')
	));
	//debug($Qgroups);
	return $Qgroups[0]['QgroupJoin']['groupID'];
	}
	
	
	public function join()
	{
	
		if($this->request->is('post'))
		{
			$code = $this->request->data['Qprofilegroup']['code'];
			//debug($code);
			
			$this->Qprofilegroup->create();
			$this->Qachievement->create();

			//debug( 'joining');
			$this->request->data['Qprofilegroup']['profileID'] = $this->Auth->user('profileID');
			$this->request->data['Qprofilegroup']['owner'] = 0;
			debug($this->findGroupCodeID($code));
			$this->request->data['Qprofilegroup']['groupID'] = $this->findGroupCodeID($code);
			
			//$this->Qachievement[][]
			$this->request->data['Qachievement']['profileID'] = $this->Auth->user('profileID');
			$this->request->data['Qachievement']['achievementID'] = 5;
			$this->request->data['Qachievement']['progress'] = 100;
			
            if ($this->Qachievement->saveAll($this->request->data)) {
				if($this->Qprofilegroup->saveAll($this->request->data))
				{
                $this->Session->setFlash(__('you have joined a group'));
                return $this->redirect(array('action' => 'index'));
				}
            }
            $this->Session->setFlash(
                __('The group could not be joined')
            );

		
		}
	
	
	
	}
 

    public function edit($id = null) 
		{
		
			$this->Qgroup->recursive = -1;
			
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid group'));
			}

			$qgroup = $this->Qgroup->find('first', array(
					'conditions' => array('Qgroup.groupID'=> $id),
					'fields' => array('Qgroup.groupID', 'Qgroup.groupType','Qgroup.groupTitle','Qgroup.groupDescription')));
					
			if (!$qgroup) 
			{
				throw new NotFoundException(__('Invalid group'));
			}
			//debug($qgroup);
			if ($this->request->is(array('post', 'put'))) 
			{
			
			$type = $this->request->data['Qgroup']['groupType'];
			$title = $this->request->data['Qgroup']['groupTitle'];
			$description = $this->request->data['Qgroup']['groupDescription'];
			$private = $this->request->data['Qgroup']['privatePublic'];
			$Qgroup['Qgroup']['groupType'] = $type;
			if ($this->Qgroup->updateAll(array('Qgroup.groupType'=>"'$type'",'Qgroup.groupTitle'=>"'$title'",
			'Qgroup.groupDescription'=>"'$description'",'Qgroup.privatePublic'=>"'$private'"), array('Qgroup.groupID' => $this->data['Qgroup']['groupID'])))
				{
				
					$this->Session->setFlash(__('Your group has been updated.'));
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to update your group.'));
				}
			}

			if (!$this->request->data) 
			{
				$this->request->data = $qgroup;
			}
		}
		
		public function delete($id) 
		{
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qprofilegroup->deleteAll(array('Qprofilegroup.groupID' => $id), false)) 
			{
				if($this->Qgroup->deleteAll(array('Qgroup.groupID' => $id), false))
				{
				$this->Session->setFlash(
					__('The Group with id: %s has been deleted.', h($id))
				);
				return $this->redirect(array('action' => 'index'));
				}
			}
		}
		
		}
?>