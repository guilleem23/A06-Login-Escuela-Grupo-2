drop database if exists bd_escola;
create database bd_escola;

use bd_escola;

create table tbl_usuari(
    idUsuari INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    cognoms VARCHAR(80),
    username VARCHAR(50) NOT NULL,
    fechaNacimiento DATE,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(40) NOT NULL,
    tipusUsuari INT
)ENGINE=InnoDB;

create table tbl_tipusUsuari(
    idTipus INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
)ENGINE=InnoDB;

create table tbl_notes(
    idNota INT PRIMARY KEY AUTO_INCREMENT,
    idUsuari INT,
    assignatura VARCHAR(50) NOT NULL,
    nota DECIMAL(4,2) NOT NULL
)ENGINE=InnoDB;

alter table tbl_notes
add constraint tbl_notes_tbl_usuari
FOREIGN KEY(idUsuari) references tbl_usuari(idUsuari);

alter table tbl_usuari
add constraint tbl_usuari_tbl_tipusUsuari
FOREIGN KEY(tipusUsuari) references tbl_tipusUsuari(idTipus);


insert into tbl_tipusUsuari (nom) values ('administrador');
insert into tbl_tipusUsuari (nom) values ('profesor');
insert into tbl_tipusUsuari (nom) values ('alumne');
insert into tbl_tipusUsuari (nom) values ('secretaria');
insert into tbl_tipusUsuari (nom) values ('families');
