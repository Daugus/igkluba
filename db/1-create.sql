drop database if exists igkluba;
-- ----------------------------------------------------------------
create database igkluba default character set utf8 default collate utf8_general_ci;
use igkluba;
SET GLOBAL event_scheduler = ON;
-- ----------------------------------------------------------------
-- create
create table if not exists centro (
  id int unsigned auto_increment primary key,
  nombre varchar(60) not null
);
create table if not exists clase (
  cod char(8) primary key,
  nombre varchar(30) not null,
  nivel tinyint(1) not null,
  curso char(9) not null,
  id_centro int unsigned not null,
  foreign key (id_centro) references centro(id)
);
create table if not exists cuenta (
  id int unsigned auto_increment primary key,
  nombre varchar(50) not null,
  apellido varchar(50) not null,
  apodo varchar(20) unique not null,
  rol enum('Admin', 'Irakasle', 'Ikasle') not null,
  activo boolean not null,
  pass varchar(100) not null,
  fecha_nacimiento date not null,
  correo varchar(100) not null,
  tel char(9),
  cod_clase char(8),
  id_centro int unsigned not null,
  foreign key (cod_clase) references clase(cod),
  foreign key (id_centro) references centro(id)
);
create table if not exists profesor_clase (
  id_profesor int unsigned not null,
  cod_clase char(8) not null,
  primary key (id_profesor, cod_clase),
  foreign key (id_profesor) references cuenta(id),
  foreign key (cod_clase) references clase(cod)
);
create table if not exists libro (
  id int unsigned auto_increment primary key,
  autor varchar(100) not null,
  serie varchar(30),
  serie_num float(4, 1),
  fecha_pub date not null,
  cantidad_reviews int unsigned not null default 0,
  nota_media float(3, 2) unsigned not null default 0,
  edad_media tinyint(2) unsigned not null default 0,
  formato enum('Nobela', 'Komikia', 'Nobela Grafikoa', 'Manga') not null,
  sinopsis varchar(2550) not null,
  enlace varchar(255) not null
);
create table if not exists etiqueta (
  nombre varchar(15) not null,
  id_libro int unsigned,
  primary key (nombre, id_libro),
  foreign key (id_libro) references libro(id)
);
create table if not exists idioma (nombre varchar(30) primary key);
create table if not exists idiomas_libro (
  id_libro int unsigned,
  nombre_idioma varchar(30),
  titulo_alternativo varchar(100),
  primary key (id_libro, nombre_idioma),
  foreign key (id_libro) references libro(id),
  foreign key (nombre_idioma) references idioma(nombre)
);
create table if not exists review (
  id int unsigned auto_increment primary key,
  nota tinyint(1) unsigned not null,
  texto varchar(2295),
  edad_lector tinyint(2) unsigned not null,
  nombre_idioma varchar(30) not null,
  id_libro int unsigned not null,
  id_cuenta int unsigned not null,
  foreign key (nombre_idioma) references idioma(nombre),
  foreign key (id_libro) references libro(id),
  foreign key (id_cuenta) references cuenta(id)
);
create table if not exists respuesta (
  id int unsigned auto_increment primary key,
  texto varchar(765) not null,
  id_review int unsigned not null,
  id_cuenta int unsigned not null,
  foreign key (id_review) references review(id),
  foreign key (id_cuenta) references cuenta(id)
);
create table if not exists solicitud_libro (
  id_libro int unsigned not null,
  id_alumno int unsigned not null,
  primary key (id_libro, id_alumno),
  foreign key (id_libro) references libro(id),
  foreign key (id_alumno) references cuenta(id)
);
create table if not exists solicitud_idioma (
  id_libro int unsigned not null,
  id_alumno int unsigned not null,
  nombre_idioma varchar(30),
  titulo_alternativo varchar(100),
  primary key (id_libro, id_alumno, nombre_idioma),
  foreign key (id_libro) references libro(id),
  foreign key (id_alumno) references cuenta(id),
  foreign key (nombre_idioma) references idioma(nombre)
);
