
CREATE DATABASE zoo;

use zoo;

CREATE USER 'rootzoo'@'localhost' IDENTIFIED BY 'brahim123';
GRANT ALL PRIVILEGES ON zoo.* TO 'rootzoo'@'localhost';
FLUSH PRIVILEGES;


create TABLE  habitat (
id int AUTO_INCREMENT PRIMARY key,
nom_hab varchar(70) NOT null,
description text  
);

create TABLE  animal (
id int AUTO_INCREMENT PRIMARY key,
nom_ani varchar(70) NOT null,
url_img  varchar(2005) not null,
idhab int  NOT null,
CONSTRAINT fk_hab FOREIGN KEY (idhab) REFERENCES habitat(id)
);

INSERT INTO habitat (nom_hab, description)
VALUES ('Savane', 'Zone chaude et sèche avec herbes hautes'),
       ('Forêt', 'Habitat dense avec beaucoup d’arbres');

INSERT INTO animal (nom_ani, url_img, idhab)
VALUES ('Lion', '/img_animaux/lion.png', 1),
       ('Singe', '/img_animaux/tiger.png', 2);
       
       UPDATE animal
SET 
    url_img = './img_animaux/lion.png'
WHERE id = 1;

UPDATE animal
SET  
    url_img = './img_animaux/tiger.png'
WHERE id = 2;




SELECT * FROM animal;


   SELECT a.nom_ani, a.url_img, h.nom_hab
FROM animal a
JOIN habitat h ON a.idhab = h.id;
    

UPDATE animal
SET nom_ani = 'Lion d’Afrique',
    url_img = '/images/lion_afrique.png'
WHERE id = 1;


-- change habitat
UPDATE animal
SET idhab = 1
WHERE id = 2;


DELETE FROM animal
WHERE nom_ani = 'Singe';

ALTER TABLE animal
ADD age INT;

ALTER TABLE animal
MODIFY url_img VARCHAR(500);

ALTER TABLE animal
DROP COLUMN age;


SHOW DATABASES;











