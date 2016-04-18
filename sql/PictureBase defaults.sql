-- ============================================== Testgögn ============================================== --
-- setjum default admin með hefðbundinni insert skipun
insert into Users(firstName,lastName,userEmail,userName,userPassword,accessLevel)
values('Konráð','Valsson','konnichiva@picturebase.xxx','konni59','Y7B62Dr0jJ',3);

-- setjum notendur í grunninn með því að kalla á Steored Procedure NewUser()
call NewUser('Jón','Jónsson','nonni@fakemail.ru','nonni666','Jr78dK23A');
call NewUser('Hafrún','Ólafsdóttir','go@somewhere.vg','haffy55','Sp09W3nNz');
call NewUser('Anna','Káradóttir','annsy@fakemail.us','annakarXXX','Al04Jut6');
call NewUser('Pétur','Hannesson','pethan@syphil.is','pjotr',')nHg65FtT');
call NewUser('Hjördís','Orradóttir','sweetheart@fakemail.dk','disaskvisa','JB5Uy68F');
call NewUser('Friðrik','Hlynsson','fridrik.hlynsson@fh.ru','frikki45','MvR45Ij6');
call NewUser('Margrét','Benediktsdóttir','maggaben@some.jp19','greta','Ew9I87gY');
call NewUser('Gunnar','Magnússon','gunnarm@','gunzo009','OwY765Gp');
call NewUser('Margrét','Jónsdóttir','magga@awesome.no','dottirmin99','T4is8E9L');
call NewUser('Pétur','Davíðsson','rokkari@grunge.gr','fhrokkar17','K7Yt41zF');
-- ============================================== oo0000oo ============================================== --


SELECT * FROM USERS;
select ValidateUser('asdasdgdfga', 'fghfghfgh');

call NewCategory('Other');
call NewImage(222,'Flott mynd', '11_-_brEwA2c.jpg', 'Rosalega flott mynd sem allir elska', 1, 1);
call NewImage(3453,'12565614_1673383276256829_2857304082979044750_n_(002)_7.png', '11_-_brEwA2c.jpg', 'Rosalega flott mynd sem allir elska', 1, 1);
call NewQuestion('Hver var fyrsti kennarinn þinn?', 1);
call NewQuestion('Hver er uppáhalds bókin þín?', 1);
call NewQuestion('Hvar áttir þú heima sem barn?', 1);

call NewQuestion('Hver var besti æskuvinur þinn?', 2);
call NewQuestion('Uppáhalds skáldaða persónan þín?', 2);
call NewQuestion('Hvað hét fyrsta gæludýrið þitt?', 2);


call NewUser('Guðni Natan', 'Gunnarsson', 'flug@an.is', 'Flugan', 'abc123', '1', 'abc', '2', 'abc');

call GetUser(1);


SELECT * FROM IMAGES;