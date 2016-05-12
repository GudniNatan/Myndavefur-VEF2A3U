drop database if exists 1803982879_PictureBase;
create database 1803982879_PictureBase;
use 1803982879_PictureBase;

drop table if exists categories;

create table categories 
(
  categoryID int(11) not null auto_increment,
  categoryName varchar(60) default null,
  categoryReadable varchar(45) default null,
  constraint category_PK primary key(categoryID),
  constraint categoryname_NQ unique(categoryName)
);

create table Questions
(
	ID int(11) primary key not null auto_increment,
    question varchar(255) not null,
    questionNumber tinyint default 1
);

create table Users 
(
  userID int(11) not null auto_increment,
  firstName varchar(55) not null,
  lastName varchar(55) not null,
  userEmail varchar(125) not null,
  userName varchar(30) not null,
  userPassword text not null,	-- Encrypted
  accessLevel tinyint default 1,									-- Hvað má notandinn sjá/gera. TD: 1 = alm notandi. 2 = súperjúser.  3 = admin
  activity bit default 1,											--  er notandinn virkur/óvirkur?
  question1id int not null,
  question1answer text not null,	-- Encrypted
  question2id int not null,
  question2answer text not null,	-- Encrypted
  constraint user_PK primary key(userID),
  constraint username_NQ unique(userName),				-- notandanafn er einkvæmt í þessum DB
  constraint useremail_NQ unique(userEmail),			-- netfang er einkvæmt líka
  foreign key(question1id) references Questions(ID),
  foreign key(question2id) references Questions(ID)
);
drop table if exists images;
create table images 
(
  imageID int(11) not null,
  imageName varchar(255) default null,
  imagePath varchar(255) not null,
  imageText varchar(155) default null,
  categoryID int(11) default null,
  userID int(11) default null,
  creation datetime default now(),
  visibility int(11) default null, -- 0 = Public, 1 = Unlisted, 2 = Private
  
  constraint image_PH primary key(imageID),
  constraint image_category_FK foreign key(categoryID) references categories (categoryID),
  foreign key(userID) references Users (userID)
);

delimiter $$
create procedure NewCategory(category_name varchar(45))
begin
	insert into Categories(categoryName)values(category_name); 
end$$
delimiter ;


delimiter $$
create procedure GetCategory(category_id int)
begin
	declare numberOfImages int;
    
    select count(categoryID) into numberOfImages from Images where categoryID = category_id;
	select categoryID,categoryName,numberOfImages from Categories where categoryID = category_id;
end$$
delimiter ;


delimiter $$
create procedure CategoryList()
begin
	select categoryID, categoryName from Categories order by categoryName;
end$$
delimiter ;


delimiter $$
create procedure UpdateCategory(category_name varchar(45), category_id int)
begin
	update Categories set categoryName = category_name 
	where categoryID = category_id;
end$$
delimiter ;


delimiter $$
create procedure DeleteCategory(category_id int)
begin
	if not exists(select categoryID from Images where categoryID = category_id) then
		delete from categories where categoryID = category_id;
	end if;
end$$
delimiter ;


delimiter $$
drop procedure if exists NewImage $$


create procedure NewImage(image_id int(11), image_name varchar(255),image_path varchar(255),image_text varchar(255),category_id int(11), user_id int(11), visibility_id int(11))
begin
	insert into Images(imageID,imageName,imagePath,imageText,categoryID,userID,visibility)
    values(image_id,image_name,image_path,image_text,category_id,user_id,visibility_id);
end$$
delimiter ;


delimiter $$
drop procedure if exists GetImage $$


create procedure GetImage(image_id int)
begin
	select I.imageID,I.imageName,I.imagePath,I.imageText,C.categoryName, I.userID, I.categoryID, I.visibility
    from Images I
    inner join Categories C on I.categoryID = C.categoryID
    and I.imageID = image_id;
end$$
delimiter ;


delimiter $$
drop procedure if exists ImageList $$

create procedure ImageList()
begin
	select I.imageID,I.imagePath,I.imageName,C.categoryName, I.userID, I.imageText
    from Images I
    inner join Categories C on I.categoryID = C.categoryID
    order by creation;
end$$
delimiter ;

delimiter $$
drop procedure if exists ImageListByUser $$

create procedure ImageListByUser(user_id int(11))
begin
	select I.imageID,I.imagePath,I.imageName,C.categoryName
    from Images I
    inner join Categories C on I.categoryID = C.categoryID
    where user_id = userID
    order by creation;
end$$
delimiter ;


delimiter $$
drop procedure if exists UpdateImage $$


create procedure UpdateImage(
	image_id int,
    image_name varchar(255),
    image_text varchar(155),
    category_id int(11), 
    visibility_id int(11)
)
begin
	update Images set imageName = image_name, imageText = image_text, categoryID = category_id, visibility = visibility_id
    where imageID = image_id;
end$$
delimiter ;


delimiter $$
create procedure DeleteImage(image_id int)
begin
	delete from Images where imageID = image_id;
end$$
delimiter ;


-- function sem validerar notandann sem loggar sig inn með notandanafni og lykilorði.
-- Í þetta skipti er ekki gert ráð fyrir dulkóðun á lykilorðinu en það kemur seinna :-)
delimiter $$
drop function if exists ValidateUser $$

create function ValidateUser(user_name varchar(30),user_pass text) 
returns varchar(255)
begin
	if exists(select userID from Users where userName = user_name and activity = 1) then
		return (select userPassword from Users where userName = user_name and activity = 1);
	else
		return "0";
	end if;
end $$
delimiter ;


-- Stored Procedure sem nýskráir notanda í gagnagrunninn(PictureBase)
-- Athugið að accessLevel er ekki settur hér.  Hann verður sjálfkrafa 1
delimiter $$
drop procedure if exists NewUser $$

create procedure NewUser
(
	first_name varchar(55),
	last_name varchar(55),
    user_email varchar(125),
    user_name varchar(30),
    user_password text,
	question_1_id int,
    question_1_answer text,	-- Encrypted
	question_2_id int,
	question_2_answer text	-- Encrypted

)
begin
	insert into Users(firstName,lastName,userEmail,userName,userPassword, question1id, question1answer, question2id, question2answer)
	values(first_name,last_name,user_email,user_name,user_password, question_1_id, question_1_answer, question_2_id, question_2_answer);
end $$
delimiter ;


-- Stored Procedure sem sækir upplýsingar um ákveðinn notanda(án lykilorðs)
delimiter $$
drop procedure if exists GetUser $$

create procedure GetUser(user_id int)
begin
	select userID,firstName,lastName,userEmail,userName,accessLevel, question1id,question1answer, question2id,question2answer
    from Users
    where userID = user_id and activity = 1;
end $$
delimiter ;


-- Stored Procedure sem sækir upplýsingar um ákveðinn notanda(án lykilorðs)
delimiter $$
drop procedure if exists GetUserByUsername $$

create procedure GetUserByUsername(user_name varchar(255))
begin
	select userID
    from Users
    where userName = user_name and activity = 1;
end $$
delimiter ;



-- Stored Procedure sem listar út alla users í PictureBase grunninum
delimiter $$
drop procedure if exists UserList $$

create procedure UserList()
begin
	select userID,firstName,lastName,userName
    from Users where activity = 1;
end $$
delimiter ;


-- Stored Procedure sem uppfærir upplýsingar um ákv. notanda
delimiter $$
drop procedure if exists UpdateUser $$

create procedure UpdateUser
(
	user_id int,
	first_name varchar(55),
	last_name varchar(55),
    user_email varchar(125),
    user_name varchar(30),
    user_password text
)
begin
	update Users 
    set firstName = first_name,lastName = last_name,userEmail = user_email,userName = user_name,userPassword = user_password
	where userId = user_id and activity = 1;
end $$
delimiter ;


-- Stored Procedure sem "eyðir" notanda.
-- Í raun er activity notandans sett á 0 en upplýsingum um hann er ekki eytt úr grunninum
delimiter $$
drop procedure if exists DeleteUser $$

create procedure DeleteUser(user_id int)
begin
	update Users set activity = 0 where userId = user_id;
end $$
delimiter ;


-- Ef notanda hefur verið "eytt" en vill "snúa aftur" þá er þesi WSP keyrður.
-- Hér er activity einfaldlega sett á 1 fyrir viðkomandi notanda.
delimiter $$
drop procedure if exists ResetUser $$

create procedure ResetUser(user_id int)
begin
	update Users set activity = 1 where userId = user_id;
end $$
delimiter ;


-- Function sem setur access level a notanda.  Aðeins sá sem er með admin réttindi( al = 3)
-- getur breytt þessum upplýsingum.
-- function skilar access level notandans; gamla gildinu er skilað ef uppgefið admin_id hefur
-- ekk accessLevel 3
delimiter $$
drop function if exists SetAccessLevel $$

create function SetAccessLevel(access_level tinyint,user_id int,admin_id int)
returns int
begin
	if(select accessLevel from Users where userID = admin_id) = 3 then
		update Users set accessLevel = access_level where userID = user_id and activity = 1;
        return access_level;
	else
		return(select accessLevel from Users where userID = user_id and activity = 1);
	end if;
end $$
delimiter ;

delimiter $$
drop procedure if exists NewQuestion $$

create procedure NewQuestion
(
	question_text varchar(255),
    question_number tinyint
)
begin
	insert into Questions(question, questionNumber)
	values(question_text, question_number);
end $$
delimiter ;


delimiter $$
drop procedure if exists Questionlist $$


create procedure Questionlist()
begin
	select ID, question, questionNumber
    from Questions;
end$$
delimiter ;


call NewQuestion('Hver var fyrsti kennarinn þinn?', 1);
call NewQuestion('Hver er uppáhalds bókin þín?', 1);
call NewQuestion('Hvar áttir þú heima sem barn?', 1);

call NewQuestion('Hvað hét fyrsta gæludýrið þitt?', 2);
call NewQuestion('Uppáhalds skáldaða persónan þín?', 2);
call NewQuestion('Hver var besti æskuvinur þinn?', 2);

