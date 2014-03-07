<?php 
class QgroupdecksController extends AppController {

	public $uses = array(
        'Qdeck','Qgroup','Qgroupdeck'
    );
	    public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		$this->loadModel('Qgroup','Qprofile','Qprofilegroup','Qachievement','Qgroupdeck');
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
									'Basic' => array('userModel' => 'Qgroupdeck'),
									'Form' => array('userModel' => 'Qgroupdeck')
		);
    }
	//This lists all the decks that belong to the group the user clicked on
	public function index($groupID) {  
       
	$this->Qgroupdeck->recursive = -1;
	  
	$Qdecks =	   $this->Qgroupdeck->find('all',array(
	 'joins' => array(
        array(
            'table' => 'Qdecks',
            'type' => 'INNER',
			'alias' => 'Qd',
            'conditions' => array(
                'Qd.deckID = Qgroupdeck.deckID'
            )
        )
    ),
    'conditions' => array(
        'Qgroupdeck.groupID' => $groupID
    ),
    'fields' => array('Qd.*','Qgroupdeck.*')
	));
    

       $this->set('Qdecks', $Qdecks);
	   $this->set('groupID', $groupID);
	   //debug('in groupdecks/index');
	   //debug($Qdecks);
	   //debug($groupID);
    }
	
	
	
		//Create new deck for the user that is logged in
	public function add($groupID) {
			if ($this->request->is('post')) {
       
            $this->Qgroupdeck->create();
			debug( 'adding');
			$this->request->data['Qgroupdeck']['groupID'] = $groupID;
			
			
            if ($this->Qgroupdeck->saveAll($this->request->data, array('deep' => true))) {
                $this->Session->setFlash(__('The deck has been created'));
                return $this->redirect(array('action' => 'index',$groupID));
            }
            $this->Session->setFlash(
                __('The deck could not be created. Please, try again.')
            );
			} 
	}

	//Delete a deck for this user TO DO: delete cards associated with the deck.
	public function delete($deckID, $groupID){
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qgroupdeck->deleteAll(array('Qgroupdeck.deckID' => $deckID), false)) 
			{
				if($this->Qdeck->deleteAll(array('Qdeck.deckID' => $deckID), false))
				{
				$this->Session->setFlash(
					__('The Deck with id: %s has been deleted.', h($deckID))
				);
				return $this->redirect(array('action' => 'index', $groupID));
				}
			}
	}	
			//Edit a users deck.
		public function edit($id = null, $groupID) 
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
					return $this->redirect(array('action' => 'index', $groupID));
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
	
}
?>