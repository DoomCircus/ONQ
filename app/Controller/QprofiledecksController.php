<?php 
class QprofiledecksController extends AppController {

	public $uses = array(
        'Qdeck','Qprofile','Qprofiledeck','Qschedule'
    );
	 public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		$this->loadModel('Qgroup','Qprofile','Qprofilegroup','Qachievement','Qschedule');
		if($this->Auth->user('role')=='user')
		{
			$this->Auth->allow('view','edit','index','add','schedule');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login');
		}
		 // Basic setup
		$this->Auth->authenticate = array('Form');

		// Pass settings in
		$this->Auth->authenticate = array(
									'Basic' => array('userModel' => 'Qdeck'),
									'Form' => array('userModel' => 'Qdeck')
		);
    }
	//This lists all the decks that belong to the user that is logged in
	public function index() {  
       
	$this->Qprofiledeck->recursive = -1;
	  
	$Qdecks = $this->Qprofiledeck->find('all',array(
	 'joins' => array(
        array(
            'table' => 'Qdecks',
            'type' => 'INNER',
			'alias' => 'Qd',
            'conditions' => array(
                'Qd.deckID = Qprofiledeck.deckID'
            )
        )
    ),
    'conditions' => array(
        'Qprofiledeck.profileID' => $this->Auth->user('profileID')
    ),
    'fields' => array('Qd.*','Qprofiledeck.*')
	));
    

       $this->set('Qdecks', $Qdecks);
	   $this->set('userID', $this->Auth->user('profileID'));
	   debug('in profiledecks/index');
	   	//debug($Qdecks);

    }

	//Create new deck for the user that is logged in
	public function add() {
			if ($this->request->is('post')) {
       
            $this->Qprofiledeck->create();
			//$this->Qschedule->create();
			debug( 'adding');
			$this->request->data['Qprofiledeck']['profileID'] = $this->Auth->user('profileID');
			//$this->request->data['Qschedule']['intervals'] = 15;
		
			//if($this->Qschedule->save($this->request->data['Qschedule']))
			
            if ($this->Qprofiledeck->saveAll($this->request->data, array('deep' => true))) {
				
                $this->Session->setFlash(__('The deck has been created'));
                return $this->redirect(array('action' => 'index'));
				
            
			}
            $this->Session->setFlash(
                __('The deck could not be created. Please, try again.')
            );
			} 
	}
	
	
	//Delete a deck for this user TO DO: delete cards associated with the deck.
	public function delete($id){
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qprofiledeck->deleteAll(array('Qprofiledeck.deckID' => $id), false)) 
			{
				if($this->Qdeck->deleteAll(array('Qdeck.deckID' => $id), false))
				{
				$this->Session->setFlash(
					__('The Deck with id: %s has been deleted.', h($id))
				);
				return $this->redirect(array('action' => 'index'));
				}
			}
	}
	
	
	
		//Edit a users deck.
		public function edit($id = null) 
		{
			$this->Qdeck->recursive = -1;
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid deck'));
			}

			$qdeck = $this->Qdeck->find('first', array(
			'conditions' => array('Qdeck.deckID'=> $id),
			'fields' => array('Qdeck.deckID', 'Qdeck.deckType', 'Qdeck.title', 'Qdeck.description','Qdeck.rating','Qdeck.privatePublic', 'Qdeck.modified')));
				
			if (!$qdeck) 
			{
				throw new NotFoundException(__('Invalid deck'));
			}
			//debug($qdeck);
			if ($this->request->is(array('post', 'put'))) 
			{
			
			unset($this->request->data['Qdeck']['modified']);
			$type = $this->request->data['Qdeck']['deckType'];
			$title = $this->request->data['Qdeck']['title'];
			$description = $this->request->data['Qdeck']['description'];
			$private = $this->request->data['Qdeck']['privatePublic'];	
			$Qdeck['Qdeck']['deckType'] = $type;
			
			if ($this->Qdeck->updateAll(array('Qdeck.deckType'=>"'$type'",'Qdeck.title'=>"'$title'",
			'Qdeck.description'=>"'$description'",'Qdeck.privatePublic'=>"'$private'"), array('Qdeck.deckID' => $this->data['Qdeck']['deckID'])))
				{
					$this->Session->setFlash(__('Your deck has been updated.'));
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to update your deck.'));
				}
			}

			if (!$this->request->data) 
			{
				$this->request->data = $qdeck;
			}
		}
		
		
		//View the details about the deck selected
		public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid deck'));
        }

		$this->Qdeck->recursive = -1;
        $qdeck = $this->Qdeck->find('first', array(
		'conditions' => array('Qdeck.deckID'=> $id),
		'fields' => array('Qdeck.deckID', 'Qdeck.deckType', 'Qdeck.title', 'Qdeck.description','Qdeck.rating','Qdeck.privatePublic','Qdeck.created','Qdeck.modified')));
        if (!$qdeck) {
            throw new NotFoundException(__('Deck does not exist'));
        }
		
		//debug($qdeck);
        $this->set('qdeck', $qdeck);
    }
	
		public function schedule($id = null,$pid = null) {
        
		$time;
		$interval;
		$val = 15;
		
		$qschedule = $this->Qschedule->find('first', array(
			'conditions' => array('Qschedule.deckID'=> $id),
			'fields' => array('Qschedule.deckID', 'Qschedule.startDay', 'Qschedule.endDay', 'Qschedule.startTime','Qschedule.endTime','Qschedule.intervals')));
				
	
		for($i = 1; $i <= 24; $i++)
		{
			$time[$i] = $i;
		}
		
		for($i = 0; $i <= 2; $i++)
		{
			$interval[$i] = $val;
			$val += 15;
		}
		//debug($qschedule);
		$this->set('time', $time);
		$this->set('interval', $interval);
		//debug($id);
		if($qschedule == null)
		{
			$this->Qschedule->create();
			if ($this->request->is('post')) {
       
				$this->Qschedule->create();
				//$this->Qschedule->create();
		
				$this->request->data['Qschedule']['deckID'] = $id;
				$this->request->data['Qschedule']['profileID'] = $pid;
				//$this->request->data['Qschedule']['intervals'] = 15;
		
				//if($this->Qschedule->save($this->request->data['Qschedule']))
			
				if ($this->Qschedule->saveAll($this->request->data, array('deep' => true))) {
				
					$this->Session->setFlash(__('The schedule has been created'));
					return $this->redirect(array('action' => 'index'));
				
            
				}
				$this->Session->setFlash(
                __('The schedule could not be created. Please, try again.')
				);
			} 
			//debug("new schedule");
		}
		else
		{
			//debug("update schedule");
			if ($this->request->is(array('post', 'put'))) 
			{
			
			
			$startd = $this->request->data['Qschedule']['startDay'];
			$endd = $this->request->data['Qschedule']['endDay'];
			$startt = $this->request->data['Qschedule']['startTime'];
			$endt = $this->request->data['Qschedule']['endTime'];	
			$interval = $this->request->data['Qschedule']['intervals'];	
			
			if ($this->Qschedule->updateAll(array('Qschedule.startDay'=>"'$startd'",'Qschedule.endDay'=>"'$endd'",
			'Qschedule.startTime'=>"'$startt'",'Qschedule.endTime'=>"'$endt'",'Qschedule.intervals'=>"'$interval'"), array('Qschedule.deckID' => $id)))
				{
					$this->Session->setFlash(__('Your deck has been updated.'));
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to update your deck.'));
				}
			}
		
		}
		
    }
	
	
	
	
	
}
?>