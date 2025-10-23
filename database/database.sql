create database db_escola;

use db_escola;

create table tbl_usuari(
    idUsuari INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    cognoms VARCHAR(80),
    username VARCHAR(50) NOT NULL,
    edad DATE,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(40) NOT NULL,
    tipusUsuari INT
);

create table tbl_tipusUsuari(
    idTipus INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

alter table tbl_usuari
add constraint tbl_usuari_tbl_tipusUsuari
FOREIGN KEY(tipusUsuari) references tbl_tipusUsuari(idTipus);


insert into tbl_tipusUsuari (nom) values ('administrador');
insert into tbl_tipusUsuari (nom) values ('profesor');
insert into tbl_tipusUsuari (nom) values ('alumne');
insert into tbl_tipusUsuari (nom) values ('secretaria');
insert into tbl_tipusUsuari (nom) values ('families');

insert into tbl_usuari (nom, username, email, password, tipusUsuari) values ('admin', 'admin', 'admin@gmail.com', '1234asdf', 1);
insert into tbl_usuari (nom, username, email, password, tipusUsuari) values ('profesor1', 'prof1', 'prof1@gmail.com', "1234asdf", 2);
insert into tbl_usuari (nom, username, email, password, tipusUsuari) values ('alumne1', 'alu1', 'alu1@gmail.com', '1234asdf', 3);
insert into tbl_usuari (nom, username, email, password, tipusUsuari) values ('secretaria1', 'secre1', 'secre1@gmail.com', '1234asdf', 4);
insert into tbl_usuari (nom, username, email, password, tipusUsuari) values ('familia1', 'fam1', 'fam1@gmail.com', '1234asdf', 5);