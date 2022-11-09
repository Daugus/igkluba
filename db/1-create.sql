drop database if exists igkluba;
-- ----------------------------------------------------------------
create database igkluba default character set utf8mb4 default collate utf8mb4_general_ci;
use igkluba;
SET GLOBAL event_scheduler = ON;
-- ----------------------------------------------------------------
-- create
create table if not exists centro (
  id int unsigned auto_increment primary key,
  nombre varchar(60) not null
);
create table if not exists clase (
  cod char(6) primary key,
  nombre varchar(30) not null,
  nivel tinyint(1) not null,
  curso char(9) not null,
  id_centro int unsigned not null,
  foreign key (id_centro) references centro(id) on delete restrict
);
create table if not exists cuenta (
  id int unsigned auto_increment primary key,
  nombre varchar(50) not null,
  apellido varchar(50) not null,
  apodo varchar(20) unique not null,
  rol enum('Admin', 'Irakasle', 'Ikasle') not null,
  activo boolean default false not null,
  pass varchar(100) not null,
  fecha_nacimiento date not null,
  correo varchar(100) not null,
  tel char(9),
  cod_clase char(8),
  id_centro int unsigned not null,
  foreign key (cod_clase) references clase(cod) on delete restrict,
  foreign key (id_centro) references centro(id) on delete restrict
);
create table if not exists profesor_clase (
  id_profesor int unsigned not null,
  cod_clase char(8) not null,
  primary key (id_profesor, cod_clase),
  foreign key (id_profesor) references cuenta(id) on delete cascade,
  foreign key (cod_clase) references clase(cod) on delete cascade
);
create table if not exists libro (
  id int unsigned auto_increment primary key,
  autor varchar(100) not null,
  serie varchar(50),
  serie_num float(4, 1),
  fecha_pub date not null,
  cantidad_reviews int unsigned not null default 0,
  nota_media float(3, 2) unsigned not null default 0,
  edad_media tinyint(2) unsigned not null default 0,
  formato enum('Nobela', 'Komikia', 'Nobela Grafikoa', 'Manga') not null,
  sinopsis varchar(2550) not null,
  aceptado boolean default false not null
);
create table if not exists etiqueta (
  nombre varchar(15) not null,
  id_libro int unsigned,
  primary key (nombre, id_libro),
  foreign key (id_libro) references libro(id) on delete cascade
);
create table if not exists idioma (
  id int unsigned auto_increment primary key,
  nombre varchar(30) unique
);
create table if not exists idiomas_libro (
  id_libro int unsigned,
  id_idioma int unsigned,
  titulo_alternativo varchar(100),
  primary key (id_libro, id_idioma),
  foreign key (id_libro) references libro(id) on delete cascade,
  foreign key (id_idioma) references idioma(id) on delete cascade
);
create table if not exists review (
  id int unsigned auto_increment primary key,
  nota tinyint(1) unsigned not null,
  texto varchar(2295),
  edad_lector tinyint(2) unsigned not null,
  aceptado boolean default false not null,
  nombre_idioma varchar(30) not null,
  id_libro int unsigned not null,
  id_cuenta int unsigned not null,
  foreign key (nombre_idioma) references idioma(nombre) on delete restrict,
  foreign key (id_libro) references libro(id) on delete cascade,
  foreign key (id_cuenta) references cuenta(id) on delete cascade
);
create table if not exists respuesta (
  id int unsigned auto_increment primary key,
  texto varchar(765) not null,
  aceptado boolean default false not null,
  id_review int unsigned not null,
  id_cuenta int unsigned not null,
  foreign key (id_review) references review(id) on delete cascade,
  foreign key (id_cuenta) references cuenta(id) on delete cascade
);
create table if not exists solicitud_libro (
  id int unsigned auto_increment primary key,
  id_libro int unsigned not null,
  id_cuenta int unsigned not null,
  foreign key (id_libro) references libro(id) on delete cascade,
  foreign key (id_cuenta) references cuenta(id) on delete cascade
);
create table if not exists solicitud_idioma (
  id int unsigned auto_increment primary key,
  id_libro int unsigned not null,
  id_cuenta int unsigned not null,
  id_idioma int unsigned not null,
  titulo_alternativo varchar(100) not null,
  foreign key (id_libro) references libro(id) on delete cascade,
  foreign key (id_cuenta) references cuenta(id) on delete cascade,
  foreign key (id_idioma) references idioma(id) on delete cascade
);
