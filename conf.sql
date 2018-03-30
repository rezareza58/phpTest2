create database PHPTest2;
use PHPTest2;

create table users (
	id int unsigned AUTO_INCREMENT not null primary key,
	firstname varchar(255) not null,
    lastname varchar(255) not null,
    email varchar(255) not null,
    role varchar(255) not null
) engine innodb charset utf8 collate utf8_bin;

create table articles (
	id int unsigned AUTO_INCREMENT not null primary key,
	title varchar(255) not null,
    picture varchar(255) not null,
    date_publish DATE,
    id_user int unsigned not null,
    foreign key (id_user) references users(id)
) engine innodb charset utf8 collate utf8_bin;


create table users_articles (
	id_user int unsigned not null,
    id_article int unsigned not null,
    foreign key (id_user)  references users(id),
    foreign key (id_article)  references articles(id)
) engine innodb charset utf8 collate utf8_bin;

INSERT INTO users(firstname, lastname, email, role) VALUES ('reza', 'RM', 'r.r.moghadam@gmail.com', 'some role');
INSERT INTO articles(title, picture, date_publish, id_user ) VALUES ('title1', 'picture', '2019-01-01', 1);

INSERT INTO users_articles VALUES (1, 1);

SELECT * FROM articles
	JOIN users_articles ON users_articles.id_article = users.id_user
    WHERE users_articles.id_article = 10;
    
    
    
    
    
