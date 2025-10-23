create database db_escola;

use db_escola;

create table tbl_usuari(
    idUsuari INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    cognoms VARCHAR(80),
    edad DATE NOT NULL,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(40) NOT NULL,
    tipusUsuari INT
);

create table tbl_tipusUsuari(
    idTipus INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

alter table tbl_usuari
add constrint tbl_usuari_tbl_tipusUsuari
FOREIGN KEY(tipusUsuari) references tbl_tipusUsuari(idTipus);