drop database if exists igkluba;
-- ----------------------------------------------------------------
create database igkluba default character set utf8 default collate utf8_general_ci;
use igkluba;
-- -- ----------------------------------------------------------------
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
  serie varchar(30) not null,
  serie_num smallint(4) not null,
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
  texto varchar(500) not null,
  id_review int unsigned,
  id_cuenta int unsigned not null,
  foreign key (id_review) references review(id),
  foreign key (id_cuenta) references cuenta(id)
);
create table if not exists solicitud_registro (
  id int unsigned auto_increment primary key,
  nombre varchar(50) not null,
  apellido varchar(50) not null,
  apodo varchar(30) not null,
  fecha_nacimiento date not null,
  cod_clase char(8) not null,
  foreign key (cod_clase) references clase(cod)
);
create table if not exists solicitud_libro (
  id int unsigned auto_increment primary key,
  titulo varchar(100) not null,
  autor varchar(100) not null,
  nombre_idioma varchar(30),
  sinopsis varchar(2550) not null,
  formato enum('Nobela', 'Komikia', 'Nobela Grafikoa', 'Manga') not null,
  etiqueta varchar(15),
  id_alumno int unsigned not null,
  foreign key (nombre_idioma) references idioma(nombre),
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
-- ------------------------------------------------------------------
-- trigger
delimiter //
create trigger recalcular_medias_insert after insert on review
for each row
begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;

  select avg(nota), avg(edad_lector), count(id)
    into media_nota, media_edad, cuenta_reviews
    from review
    where id_libro = NEW.id_libro;

  update libro
  set nota_media = media_nota, edad_media = media_edad, cantidad_reviews = cuenta_reviews
    where id = NEW.id_libro;
end;//
-- ------------------------------------------------------------------
create trigger recalcular_medias_update after update on review
for each row
begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;

  select avg(nota), avg(edad_lector), count(id)
    into media_nota, media_edad, cuenta_reviews
    from review
    where id_libro = NEW.id_libro;

  update libro
  set nota_media = media_nota, edad_media = media_edad, cantidad_reviews = cuenta_reviews
    where id = NEW.id_libro;
end;//
-- ------------------------------------------------------------------
create trigger recalcular_medias_delete after delete on review
for each row
begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;

  select avg(nota), avg(edad_lector), count(id)
    into media_nota, media_edad, cuenta_reviews
    from review
    where id_libro = OLD.id_libro;

  update libro
  set nota_media = media_nota, edad_media = media_edad, cantidad_reviews = cuenta_reviews
    where id = OLD.id_libro;
end;//
delimiter ;
-- ------------------------------------------------------------------
-- insert
insert into centro
values (1, 'Unamuno');
insert into clase
values ('1234abcd', '2dw3', 3, '2022-2023', 1);
insert into cuenta (
    id,
    nombre,
    apellido,
    apodo,
    rol,
    activo,
    pass,
    fecha_nacimiento,
    tel,
    cod_clase,
    id_centro
  )
values (
    1,
    'Leyre',
    'Boyra',
    'lboyra',
    'admin',
    true,
    '$2y$10$dPLb4Xobi78PUlFtWuAzi.2SIAVtqhY2dmrfrdA1ICfYXmfY/nvSS',
    '2000-1-1',
    null,
    null,
    1
  ),
  (
    2,
    'Augusto',
    'de la Cámara',
    'dlc',
    'admin',
    true,
    '$2y$10$dPLb4Xobi78PUlFtWuAzi.2SIAVtqhY2dmrfrdA1ICfYXmfY/nvSS',
    '2002-12-26',
    null,
    null,
    1
  ),
  (
    3,
    'Unai',
    'Cabo',
    'ucabo',
    'irakasle',
    true,
    '$2y$10$dPLb4Xobi78PUlFtWuAzi.2SIAVtqhY2dmrfrdA1ICfYXmfY/nvSS',
    '2000-1-1',
    '987654321',
    null,
    1
  ),
  (
    4,
    'Xabi',
    'Bravo',
    'xbravo',
    'ikasle',
    true,
    '$2y$10$dPLb4Xobi78PUlFtWuAzi.2SIAVtqhY2dmrfrdA1ICfYXmfY/nvSS',
    '2000-1-1',
    null,
    '1234abcd',
    1
  ),
  (
    5,
    'Nombre',
    'Apellidos',
    'test',
    'ikasle',
    true,
    '$2y$10$dPLb4Xobi78PUlFtWuAzi.2SIAVtqhY2dmrfrdA1ICfYXmfY/nvSS',
    '2000-1-1',
    null,
    '1234abcd',
    1
  );
insert into profesor_clase
values (3, '1234abcd');
insert into idioma
values ('Ingelesa'),
  ('Euskara'),
  ('Gaztelania');
insert into libro (
    -- titulo,
    id,
    autor,
    serie,
    serie_num,
    fecha_pub,
    formato,
    sinopsis,
    enlace
  )
values (
    1,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    1,
    '2010-8-31',
    'nobela',
    'En Roshar, un mundo de piedra y tormentas, extrañas tempestades de increíble potencia barren el rocoso territorio de tal manera que han dado forma a una nueva civilización escondida. Han pasado siglos desde la caída de las diez órdenes consagradas conocidas como los Caballeros Radiantes, pero sus espadas y armaduras aún permanecen. En las Llanuras Quebradas se libra una guerra sin sentido. Kaladin ha sido sometido a la esclavitud, mientras diez ejércitos luchan por separado contra un solo enemigo. El comandante de uno de los otros ejércitos, el señor Dalinar, se siente fascinado por un antiguo texto llamado \'El camino de los reyes\'. Mientras tanto, al otro lado del océano, su eminente y hereje sobrina, Jasnah Kholin, forma a su discípula, la joven Shallan, quien investigará los secretos de los Caballeros Radiantes y la verdadera causa de la guerra.',
    'https://www.todostuslibros.com/libros/el-camino-de-los-reyes-el-archivo-de-las-tormentas-1_978-84-1314-394-1'
  ),
  (
    2,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    2,
    '2014-3-4',
    'nobela',
    'Los Caballeros Radiantes deben volver a alzarse. Los antiguos juramentos por fin se han pronunciado. Los hombres buscan lo que se perdió. Temo que la búsqueda los destruya. Es la naturaleza de la magia. Un alma rota tiene grietas donde puede colarse algo más. Las potencias, los poderes de la creación misma, pueden abrazar un alma rota, pero también pueden ampliar sus fisuras. El Corredor del Viento está perdido en una tierra quebrada, en equilibro entre la venganza y el honor. La Tejedora de Luz, lentamente consumida por su pasado, busca la mentira en la que debe convertirse. El Forjador de Vínculos, nacido en la sangre y la muerte, se esfuerza ahora por reconstruir lo que fue destruido. La Exploradora, a caballo entre los destinos de dos pueblos, se ve obligada a elegir entre una muerte lenta y una terrible traición a todo en lo que cree. Ya es hora de despertarlos, pues acecha la eterna tormenta. Y el asesino ha llegado.',
    'https://www.todostuslibros.com/libros/palabras-radiantes-el-archivo-de-las-tormentas-2_978-84-1314-395-8'
  );
insert into etiqueta
values ('Fantasia', 1),
  ('Fantasia', 2);
insert into idiomas_libro
values (1, 'Gaztelania', 'El Camino de los Reyes'),
  (1, 'Ingelesa', 'The Way of Kings'),
  (2, 'Gaztelania', 'Palabras Radiantes'),
  (2, 'Ingelesa', 'Words of Radiance');
insert into review (
    id,
    nota,
    texto,
    edad_lector,
    nombre_idioma,
    id_libro,
    id_cuenta
  )
values (1, 4, 'bien', 20, 'Gaztelania', 1, 3),
  (2, 1, 'mal', 10, 'Euskara', 1, 4),
  (3, 2, 'meh', 20, 'Gaztelania', 2, 3),
  (4, 5, 'increíble', 10, 'Euskara', 2, 4);
insert into respuesta
values (1, 'respuesta a bien', 1, 5),
  (2, 'respuesta a mal', 2, 5);