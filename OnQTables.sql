
use OnQ;
create table QAddress
(
	addressID int not null auto_increment primary key,
	unitNumber int,
	aptNumber int,
	streetName varchar(20),
	stateProvince varchar(20),
	postalCode varchar(20)

);

create table QLog
(
	logID int not null auto_increment primary key,
	logDate datetime,
	logAction varchar(20),
	logMessage varchar(20)

);

create table QProfile
(
	profileID int not null auto_increment,
	userName varchar(20),
	passwords varchar(20),
	firstName varchar(20),
	lastName varchar(20),
	role varchar(20),
	dateOfBirth datetime,
	dateCreated datetime,
	dateModified datetime,
	emailAddress varchar(20),
	maleFemale bit,
	addressID int,
	logID int,

	foreign key (addressID) references QAddress(addressID),
	foreign key (logID) references QLog(logID),
	primary key(profileID, userName, emailAddress)
);


create Table QAdvertisment
(

	advertismentID int not null auto_increment primary key,
	advertisment blob

);

create table QProfileAdvertisment
(
	profileID int not null,
	advertismentID int not null,
	
	foreign key (profileID) references QProfile(profileID)
	on delete cascade
	on update cascade,
	foreign key (advertismentID) references QAdvertisment(advertismentID)
	on delete cascade
	on update cascade
);



create table QGroup
(
	groupID int not null auto_increment primary key,
	groupType varchar(20),
	groupTitle varchar(20),
	groupDescription varchar(20),
	lastModified datetime,
	groupCode varchar(20),
	privatePublic bit


);

create table QProfileGroup
(
	profileID int not null,
	groupID int not null,
	
	foreign key (profileID) references QProfile(profileID)
	on delete cascade
	on update cascade,
	foreign key (groupID) references QGroup(groupID)
	on delete cascade
	on update cascade
);


create Table QDeck
(

	deckID int not null auto_increment primary key,
	deckType varchar(20),
	title varchar(20) ,
	description varchar(20),
	lastModified datetime,
	rating float,
	privatePublic bit

);

create Table QProfileDecks
(
	deckID int not null,
	profileID int not null,

	foreign key (profileID) references QProfile(profileID)
	on delete cascade
	on update cascade,
	foreign key (deckID) references QDeck(deckID)
	on delete cascade
	on update cascade

);


create table QGroupDeck
(

	groupID int not null,
	deckID int not null,
	
	foreign key (groupID) references QGroup(groupID)
	on delete cascade
	on update cascade,
	foreign key (deckID) references QDeck(deckID)
	on delete cascade
	on update cascade

);

create Table QType
(

	typeID int not null auto_increment primary key,
	typeName varchar(20)

);


create table QAchievement
(

	achievementID int not null auto_increment primary key,
	achievementName varchar(20),
	details varchar(20) ,
	typeID int,
	
	foreign key (typeID) references QType(typeID)
	on delete cascade
	on update cascade

);


create table QProfileAchievment
(

	profileID int not null,
	achievementID int not null,
	progress float,

	foreign key (profileID) references QProfile(profileID)
	on delete cascade
	on update cascade,
	foreign key (achievementID) references QAchievement(achievementID)
	on delete cascade
	on update cascade
);


create Table QCard
(

	cardID int not null auto_increment primary key,
	cardType varchar(20),
	question varchar(20) ,
	answer varchar(20)

);

create Table QDeckCard
(
	deckID int not null,
	cardID int not null,

	foreign key (deckID) references QDeck(deckID)
	on delete cascade
	on update cascade,
	foreign key (cardID) references QCard(cardID)
	on delete cascade
	on update cascade

);

create Table QGame
(
	gameID int not null auto_increment primary key,
	gameName varchar(20)
);

create Table QDeckGames
(
	gameID int not null,
	deckID int not null,

	foreign key (gameID) references QGame(gameID)
	on delete cascade
	on update cascade,
	foreign key (deckID) references QDeck(deckID)
	on delete cascade
	on update cascade

);

create Table QAchievementGroup
(
	groupID int not null,
	achievementID int not null,

	foreign key (groupID) references QGroup(groupID)
	on delete cascade
	on update cascade,
	foreign key (achievementID) references QAchievement(achievementID)
	on delete cascade
	on update cascade

);

create Table QAchievementDeck
(
	deckID int not null,
	achievementID int not null,

	foreign key (deckID) references QDeck(deckID)
	on delete cascade
	on update cascade,
	foreign key (achievementID) references QAchievement(achievementID)
	on delete cascade
	on update cascade

);

create Table QGameAchievement
(
	gameID int not null,
	achievementID int not null,

	foreign key (gameID) references QGame(gameID)
	on delete cascade
	on update cascade,
	foreign key (achievementID) references QAchievement(achievementID)
	on delete cascade
	on update cascade

);

