<?php 
class QdeckcardsController extends AppController {

	public $uses = array(
        'Qcard','Qdeck','Qdeckcard'
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
	
	public function index($deckID) {  
	$Qcards = $this->Qdeckcard->find('all',array(
	 'joins' => array(
        array(
            'table' => 'Qcards',
            'type' => 'INNER',
			'alias' => 'Qc',
            'conditions' => array(
                'Qc.cardID = Qdeckcard.cardID'
            )
        )
    ),
    'conditions' => array(
        'Qdeckcard.deckID' => $deckID
    ),
    'fields' => array('Qc.*','Qdeckcard.*')
	));
    

       $this->set('Qcards', $Qcards);
	   $this->set('deckID', $deckID);
	   $this->set('userID', $this->Auth->user('profileID'));
	   //debug($Qcards);
	   //debug('in deckcards/index');
	   //debug($deckID);
    }

	public function add($deckID) {
			if ($this->request->is('post')) {
			
			$this->Qcard->create();
            $this->Qdeckcard->create();

				if($this->Qcard->save($this->request->data))
				{
					$cardID = $this->Qcard->getLastInsertID();
					$this->request->data['Qdeckcard']['cardID'] = $cardID;
					$this->request->data['Qdeckcard']['deckID'] = $deckID;
						if($this->Qdeckcard->save($this->request->data))
						{
						$this->Session->setFlash(__('The card has been added'));
						return $this->redirect(array('action' => 'index', $deckID));
						}
						else
						{
							debug('in deckcards/add');
							debug($deckID);
							debug($userID);
							//debug($this->Qdeckcard->save($this->request->data));
							$this->Session->setFlash(__('The card has NOT been added'));
						}
				}
			}
	}
	
	
	
	
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
	
	
	
	
	
}
?>