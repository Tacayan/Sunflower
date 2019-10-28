create database sunflower;

use sunflower;

create table ex
(
    name  varchar(255)                                       null,
    codEx int auto_increment
        primary key,
    photo varchar(255) default 'user/photo/user.jpg' null
);

create table log
(
    log   varchar(500) not null,
    codEx int(5)  not null
);

