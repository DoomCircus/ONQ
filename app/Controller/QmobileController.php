<?php 
/*
 *  Project : OnQ
 *  File : QMobileController.php
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 18, 2014
 *  Description : QMobileController is the controller class that handles the OnQ mobile app RESTful APIs for pulling
 *					a users decks from the database and adding decks that users receive through bumping decks
 */

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class QmobileController extends AppController
{	
	//Models being used by the controller
	public $uses = array(
        'Qprofile','Qprofiledecks','Qdecks','Qdeckcards','Qcards'
    );
	
	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- login
		*
		*	Purpose :   This function connects a users mobile app to OnQ, it then assigns their
		*				app a unique security token to be passed as an argument to uploadDecks
		*	Inputs	:	$userName - username that decks and cards are being requested for
		*				$password - used to authenticate the user when they try to pull decks/cards
		*	Outputs	:	None
		*	Returns	:	JSON string with users decks or an error message if an error occurred
	----------------------------------------------------------------------------------------*/
	public function login($userName, $password)
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
	
		//If a user name and password have been passed with the request
		if ($userName != null && $password != null)
		{
			$passwordHasher = new SimplePasswordHasher();
			$password = $passwordHasher->hash($password); //Hashes the password for comparison with the users password in the database
			
			//Find the profile that matches the passed in username
			$profile = $this->Qprofile->find('first', array(
											'conditions' => array('Qprofile.userName'=> $userName),
											'fields' => array('Qprofile.profileID', 'Qprofile.userName', 'Qprofile.password',
															'Qprofile.emailAddress', 'Qprofile.dateOfBirth', 'Qprofile.dateCreated')));
			
			//If a profile was not found
			if (!$profile)
			{
				$error[0] = 'Error';
				$error[1] = 'You are not a registered user of OnQ';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			//If the password passed in does not match the password of the profile in the database
			if ($password != $profile['Qprofile']['password'])
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid password';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			/*
			*	User exists and has provided the correct password, generate their unique security token
			*/
			
			//Return profileID | userName | password | emailAddress | password | dob | dateCreated
			$token[0] = 'SecurityToken';
			$token[1] = $profile['Qprofile']['profileID'] | $profile['Qprofile']['userName'] | $profile['Qprofile']['password'] |
						$profile['Qprofile']['emailAddress'] | $profile['Qprofile']['dateOfBirth'] | $profile['Qprofile']['dateCreated'];
			
			//Returns auth token to be held in app stored preferences
			return json_encode($token); //Return the JSON string that represents security token for the users app
		}
		else
		{
			$error[0] = 'Error';
			$error[1] = 'Missing username or password';
			return json_encode($error); //Return a JSON string notifying the user of the error
		}
	}
	
	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- pullDecks
		*
		*	Purpose :   This function returns a users decks/cards to their mobile app after
		*				they are authenticated
		*	Inputs	:	$userName - username that decks and cards are being requested for
		*				$password - used to authenticate the user when they try to pull decks/cards
		*	Outputs	:	None
		*	Returns	:	JSON string with users decks or an error message if an error occurred
	----------------------------------------------------------------------------------------*/
    public function pullDecks($userName, $password)
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
		
		//If a user name and password have been passed with the request
		if ($userName != null && $password != null)
		{
			$passwordHasher = new SimplePasswordHasher();
			$password = $passwordHasher->hash($password); //Hashes the password for comparison with the users password in the database
			
			//Find the profile that matches the passed in username
			$profile = $this->Qprofile->find('first', array(
											'conditions' => array('Qprofile.userName'=> $userName),
											'fields' => array('Qprofile.profileID', 'Qprofile.userName', 'Qprofile.password')));
			
			//If a profile was not found
			if (!$profile)
			{
				$error[0] = 'Error';
				$error[1] = 'You are not a registered user of OnQ';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			//If the password passed in does not match the password of the profile in the database
			if ($password != $profile['Qprofile']['password'])
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid password';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			/*
			*	Start fishing out users decks/cards from the database
			*/
			
			//Get the IDs of all the decks that are associated with the users profile
			$deckIDs = $this->Qprofiledecks->find('all', array(
											'conditions' => array('Qprofiledecks.profileID'=> $profile['Qprofile']['profileID']),
											'fields' => array('Qprofiledecks.deckID')));
			
			$decks = array(); //New array to hold decks and cards found for the user
			
			//For each deck by ID
			for ($x = 0; $x < count($deckIDs); ++$x)
			{
				//Grab the deck from the database that matches the current deckID
				$decks[$x] = $this->Qdecks->find('first', array(
											'conditions' => array('Qdecks.deckID'=> $deckIDs[$x]['Qprofiledecks']['deckID'])));
				
				//Get IDs of all the cards associated with the current deck
				$cardIDs = $this->Qdeckcards->find('all', array(
												'conditions' => array('Qdeckcards.deckID'=> $decks[$x]['Qdecks']['deckID']),
												'fields' => array('Qdeckcards.cardID')));
				
				$decks[$x]['Qdeckcards'] = array(); //New array to hold cards found for the current deck
				
				//For each card by ID in the current deck
				for ($y = 0; $y < count($cardIDs); ++$y)
				{
					//Grab the card from the database that matches the current cardID
					$decks[$x]['Qdeckcards'][$y] = $this->Qcards->find('first', array(
																'conditions' => array('Qcards.cardID'=> $cardIDs[$y]['Qdeckcards']['cardID'])));
				}
			}
			return json_encode($decks); //Return the JSON string that represents the decks and cards found for the user
		}
		else
		{
			$error[0] = 'Error';
			$error[1] = 'Missing username or password';
			return json_encode($error); //Return a JSON string notifying the user of the error
		}
    }

	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- uploadDecks
		*
		*	Purpose :   This function returns allows a user to push new decks obtained through
						Bump in the mobile app to their collection in the database
		*	Inputs	:	$userName - username that decks and cards are being requested for
		*				$password - used to authenticate the user when they try to pull decks/cards
		*				$authToken - unique security token from users app
		*				$jsonDecks (passed in the URL) - decks to be added to the database (as JSON string)
		*	Outputs	:	None
		*	Returns	:	JSON string containing success or error message
	----------------------------------------------------------------------------------------*/
    public function uploadDecks($userName, $password, $authToken)
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
		
		//If a user name and password have been passed with the request
		if ($userName != null && $password != null)
		{
			$passwordHasher = new SimplePasswordHasher();
			$password = $passwordHasher->hash($password); //Hashes the password for comparison with the users password in the database
			
			//Find the profile that matches the passed in username
			$profile = $this->Qprofile->find('first', array(
											'conditions' => array('Qprofile.userName'=> $userName),
											'fields' => array('Qprofile.profileID', 'Qprofile.userName', 'Qprofile.password',
															'Qprofile.emailAddress', 'Qprofile.dateOfBirth', 'Qprofile.dateCreated')));
			
			//If a profile was not found
			if (!$profile)
			{
				$error[0] = 'Error';
				$error[1] = 'You are not a registered user of OnQ';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			//If the password passed in does not match the password of the profile in the database
			if ($password != $profile['Qprofile']['password'])
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid password';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			/*
			*	User exists and has provided the correct password, authenticate their unique security token
			*/
			
			if (!$authToken)
			{
				$error[0] = 'Error';
				$error[1] = 'User not previously signed into the OnQ mobile app';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			$generatedToken = $profile['Qprofile']['profileID'] | $profile['Qprofile']['userName'] | $profile['Qprofile']['password'] |
							$profile['Qprofile']['emailAddress'] | $profile['Qprofile']['dateOfBirth'] | $profile['Qprofile']['dateCreated'];
			
			if ($authToken !== $generatedToken)
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid security token';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			
			//Only way to parse out JSON string containing decks, all other methods corrupt string
			$urlPieces = explode('/', $this->request->url);
			$decksPos = 5;
			
			//If there are decks to be processed
			if (!$urlPieces[$decksPos])
			{
				$error[0] = 'Error';
				$error[1] = 'There are no decks to add';
				return json_encode($error); //Return a JSON string notifying the user of the error
			}
			$decks = json_decode(urldecode($urlPieces[$decksPos]));
			
			/*
			*	Start parsing JSON object of decks, check if they exist
			*	in the database and insert the ones that don't
			*/
			$result[0] = 'Success';
			$result[1] = '';
			
			for ($x = 0; $x < count($decks); ++$x)
			{
				//Check if the deck exists in the database
				$deck = $this->Qdecks->find('first', array('conditions' => array('Qdecks.deckID'=> $decks[$x]->Qdecks->deckID)));
				
				//If the deck is not in the database
				if (!$deck)
				{
					//Insert the deck into the database
					if (!$this->Qdecks->save($decks[$x]->Qdecks))
					{
						$result[0] = 'Failure';
						$result[1] .= 'Failure to add '.$decks[$x]->Qdecks->title.' to the database';
					}
				}
				
				//Check if the deck is in the user's decks in the database
				$pDeck = $this->Qprofiledecks->find('first', array('conditions' => array(
														'Qprofiledecks.deckID'=> $decks[$x]->Qdecks->deckID,
														'Qprofiledecks.profileID'=> $profile['Qprofile']['profileID']
													)));
				
				//If the deck is not in the database
				if (!$pDeck)
				{
					$pDeck['Qprofiledeck']['profileID'] = $profile['Qprofile']['profileID'];
					$pDeck['Qprofiledeck']['deckID'] = $decks[$x]->Qdecks->deckID;
					//Link the deck to the user's profile
					if (!$this->Qprofiledecks->save($pDeck))
					{
						$result[0] = 'Failure';
						$result[1] .= 'Failure to add '.$pDeck['Qprofiledeck']['deckID'].' to '.$profile['Qprofile']['userName']."'s decks";
					}
				}
				
				for ($y = 0; $y < count($decks[$x]->Qdeckcards); ++$y)
				{
					//Check if the card exists in the database
					$card = $this->Qcards->find('first', array('conditions' => array('Qcards.cardID'=> $decks[$x]->Qdeckcards[$y]->Qcards->cardID)));
					
					//If the deck is not in the database
					if (!$card)
					{
						//Insert the deck into the database
						if (!$this->Qcards->save($card))
						{
							$result[0] = 'Failure';
							$result[1] .= 'Failure to add '.$decks[$x]->Qdeckcards[$y]->Qcards->question.' to the database';
						}
					}
					
					//Check if the card exists in the current deck
					$deckcard = $this->Qdeckcards->find('first', array('conditions' => array(
															'Qdeckcards.deckID'=> $decks[$x]->Qdecks->deckID,
															'Qdeckcards.cardID'=> $decks[$x]->Qdeckcards[$y]->Qcards->cardID
														)));
					
					//If the card is not in the current deck
					if (!$deckcard)
					{
						$deckcard['Qdeckcard']['deckID'] = $decks[$x]->Qdecks->deckID;
						$deckcard['Qdeckcard']['deckID'] = $decks[$x]->Qdeckcards[$y]->Qcards->cardID;
						//Link the card to the current deck
						if (!$this->Qdeckcards->save($deckcard))
						{
							$result[0] = 'Failure';
							$result[1] .= 'Failure to add '.$decks[$x]->Qdeckcards[$y]->Qcards->question.' to the database';
						}
					}
				}
			}
			if ($result[0] == 'Success')
			{
				$result[1] = 'All decks successfully added/updated';
			}
			return json_encode($result); //Return a JSON string notifying the user of the result of the upload
		}
		else
		{
			$error[0] = 'Error';
			$error[1] = 'Missing username, password, or security token';
			return json_encode($error); //Return a JSON string notifying the user of the error
		}
    }
}
?>