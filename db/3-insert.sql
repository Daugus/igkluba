use igkluba;
-- ----------------------------------------------------------------
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
    correo,
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
    'leireirakas21@gmail.com',
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
    'augustodelacamara@gmail.com',
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
    'ejemplo@gmail.com',
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
    'ejemplo@gmail.com',
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
    'ejemplo@gmail.com',
    null,
    '1234abcd',
    1
  );
insert into profesor_clase
values (3, '1234abcd');
insert into idioma
values ('Ingelesa'),
  ('Euskara'),
  ('Gaztelania'),
  ('Frantsesa');
insert into libro (
    id,
    autor,
    serie,
    serie_num,
    fecha_pub,
    formato,
    sinopsis,
    enlace,
    aceptado
  )
values (
    1,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    1,
    '2010-8-31',
    'nobela',
    'Anhelo los días previos a la Última Desolación. Los días en que los Heraldos nos abandonaron y los Caballeros Radiantes se giraron en nuestra contra. Un tiempo en que aún había magia en el mundo y honor en el corazón de los hombres. El mundo fue nuestro, pero lo perdimos. Probablemente no hay nada más estimulante para las almas de los hombres que la victoria. ¿O tal vez fue la victoria una ilusión durante todo ese tiempo? ¿Comprendieron nuestros enemigos que cuanto más duramente luchaban, más resistíamos nosotros? Quizá vieron que el fuego y el martillo tan solo producían mejores espadas. Pero ignoraron el acero durante el tiempo suficiente para oxidarse. Hay cuatro personas a las que observamos. La primera es el médico, quien dejó de curar para convertirse en soldado durante la guerra más brutal de nuestro tiempo. La segunda es el asesino, un homicida que llora siempre que mata. La tercera es la mentirosa, una joven que viste un manto de erudita sobre un corazón de ladrona. Por último está el alto príncipe, un guerrero que mira al pasado mientras languidece su sed de guerra. El mundo puede cambiar. La potenciación y el uso de las esquirlas pueden aparecer de nuevo, la magia de los días pasados puede volver a ser nuestra. Esas cuatro personas son la clave.',
    'https://www.todostuslibros.com/libros/el-camino-de-los-reyes-el-archivo-de-las-tormentas-1_978-84-1314-394-1',
    true
  ),
  (
    2,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    2,
    '2014-3-4',
    'nobela',
    'Los Caballeros Radiantes deben volver a alzarse. Los antiguos juramentos por fin se han pronunciado. Los hombres buscan lo que se perdió. Temo que la búsqueda los destruya. Es la naturaleza de la magia. Un alma rota tiene grietas donde puede colarse algo más. Las potencias, los poderes de la creación misma, pueden abrazar un alma rota, pero también pueden ampliar sus fisuras. El Corredor del Viento está perdido en una tierra quebrada, en equilibro entre la venganza y el honor. La Tejedora de Luz, lentamente consumida por su pasado, busca la mentira en la que debe convertirse. El Forjador de Vínculos, nacido en la sangre y la muerte, se esfuerza ahora por reconstruir lo que fue destruido. La Exploradora, a caballo entre los destinos de dos pueblos, se ve obligada a elegir entre una muerte lenta y una terrible traición a todo en lo que cree. Ya es hora de despertarlos, pues acecha la eterna tormenta. Y el asesino ha llegado.',
    'https://www.todostuslibros.com/libros/palabras-radiantes-el-archivo-de-las-tormentas-2_978-84-1314-395-8',
    true
  ),
  (
    3,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    3,
    '2017-11-14',
    'nobela',
    'La humanidad se enfrenta a una nueva Desolación con el regreso de los Portadores del Vacío, un enemigo tan grande en número como en sed de venganza. La victoria fugaz de los ejércitos alezi de Dalinar Kholin ha tenido consecuencias: el enemigo parshendi ha convocado la violenta tormenta eterna, que arrasa el mundo y hace que los hasta ahora pacíficos parshmenios descubran con horror que llevan un milenio esclavizados por los humanos. Al mismo tiempo, en una desesperada huida para alertar a su familia de la amenaza, Kaladin se pregunta si la repentina ira de los parshmenios está justificada. Entretanto, en la torre de la ciudad de Urithiru, a salvo de la tormenta, Shallan Davar investiga las maravillas de la antigua fortaleza de los Caballeros Radiantes y desentierra oscuros secretos que acechan en las profundidades. Dalinar descubre entonces que su sagrada misión de unificar su tierra natal de Alezkar era corta de miras. A menos que todas las naciones sean capaces de unirse y dejar de lado el pasado sangriento de Dalinar, ni siquiera la restauración de los Caballeros Radiantes conseguirá impedir el fin de la civilización.',
    'https://www.todostuslibros.com/libros/juramentada-el-archivo-de-las-tormentas-3_978-84-17347-00-0',
    true
  ),
  (
    4,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    4,
    '2020-11-17',
    'nobela',
    'Hay secretos que hemos guardado mucho tiempo. Vigilantes. Insomnes. Eternos. Y pronto dejarán de ser nuestros. La Una que es Tres busca, sin saberlo, el alma capturada. El spren aprisionado, olvidado hace mucho tiempo. ¿Puede liberar su propia alma a tiempo de hallar el conocimiento que condena a todos los pueblos de Roshar? El Soldado Caído acaricia y ama la lanza, incluso mientras el arma hiende su propia carne. Camina siempre hacia delante, siempre hacia la oscuridad, sin luz. No puede llevar consigo a nadie, salvo aquello que él mismo puede avivar. La Hermana Derrumbada comprende sus errores y piensa que ella misma es un error. Parece muy alejada de sus antepasados, pero no comprende que son quienes la llevan a hombros. Hacia la victoria, y hacia ese silencio, el más importante de todos. Y la Madre de Máquinas, la más crucial de todos ellos, danza con mentirosos en un gran baile. Debe desenmascararlos, alcanzar sus verdades ocultas y entregarlas al mundo. Tiene que reconocer que las peores mentiras son las que se cuenta a sí misma. Si lo hace, nuestros secretos por fin se convertirán en verdades.',
    'https://www.todostuslibros.com/libros/el-ritmo-de-la-guerra-el-archivo-de-las-tormentas-4_978-84-17347-93-2',
    true
  ),
  (
    5,
    'Jabois, Manuel',
    null,
    null,
    '2019-05-16',
    'nobela',
    '«La primera vez que papá murió todos pensamos que estaba fingiendo.»
Así empieza Malaherba de Manuel Jabois. Un día Mr. Tamburino, Tambu, un niño de diez años, se encuentra a su padre tirado en la habitación y conoce a Elvis, un nuevo compañero de su clase. Descubrirá por primera vez el amor y la muerte, pero no de la forma que él cree. Y los dos, Tambu y Elvis, vivirán juntos los últimos días de la niñez, esos en los que aún pasan cosas que no se pueden explicar y sentimientos a los que todavía no se sabe poner nombre
Esta es una historia de dos niños que viven una extraña y solitaria historia de amor. Un libro sobre las cosas terribles que se hacen con cariño, escrito con humor y una prosa rápida que avanza llevando a Tambu y su hermana Rebe, a Claudia y su hermano Elvis, a la frontera de un mundo nuevo.
«Bien sabe Dios que es más peligrosa la pena que el odio, porque el odio puede destruir lo que odias, pero la pena lo destruye todo.»',
    'https://www.todostuslibros.com/libros/malaherba_978-84-663-5338-0',
    true
  ),
  (
    6,
    'Mallorquí del Corral, César',
    null,
    null,
    '2002-01-01',
    'nobela',
    'En cierta ocasión, hace ya mucho tiempo, vi un fantasma. Sí, un espectro, una aparición, un espíritu; lo puedes llamar como quieras, el caso es que lo vi. Ocurrió el mismo año en que el hombre llegó a la Luna y, aunque hubo momentos en los que pasé mucho miedo, esta historia no es lo que suele llamarse una novela de terror. -Todo comenzó con un enigma: el misterio de un objeto muy valioso que estuvo perdido durante siete décadas. Las Lágrimas de Shiva, así se llamaba ese objeto extraviado. A su alrededor tuvieron lugar venganzas cruzadas, y amores prohibidos, y extrañas desapariciones.-Hubo un fantasma, sí, y un viejo secreto oculto en las sombras, pero también hubo mucho más.',
    'https://www.todostuslibros.com/libros/las-lagrimas-de-shiva_978-84-236-7510-4',
    false
  ),
  (
    7,
    'Rowling, J.K.',
    'Harry Potter',
    1,
    '1997-12-26',
    'nobela',
    '«Con las manos temblorosas, Harry le dio la vuelta al sobre y vio un sello de lacre púrpura con un escudo de armas: un león, un águila, un tejón y una serpiente, que rodeaban una gran letra H.»
Harry Potter nunca ha oído hablar de Hogwarts hasta que empiezan a caer cartas en el felpudo del número 4 de Privet Drive. Llevan la dirección escrita con tinta verde en un sobre de pergamino amarillento con un sello de lacre púrpura, y sus horripilantes tíos se apresuran a confiscarlas. Más tarde, el día que Harry cumple once años, Rubeus Hagrid, un hombre gigantesco cuyos ojos brillan como escarabajos negros, irrumpe con una noticia extraordinaria: Harry Potter es un mago, y le han concedido una plaza en el Colegio Hogwarts de Magia y Hechicería. ¡Está a punto de comenzar una aventura increíble!',
    'https://www.todostuslibros.com/libros/harry-potter-y-la-piedra-filosofal-harry-potter-1_978-84-7888-445-2',
    false
  ),
  (
    8,
    'Santiago, Roberto',
    'Los Futbolísimos',
    1,
    '2013-05-16',
    'komikia',
    'El equipo de fútbol 7 Soto Alto no es solo el equipo de fútbol del colegio. Es mucho más. Nosotros hemos hecho un pacto: nada ni nadie nos separará nunca. Siempre jugaremos juntos. Pase lo que pase. Así que cuando pasó lo que pasó no tuvimos más remedio que actuar. Preparamos nuestro material de investigadores... y nos lanzamos a la aventura. Por algo somos los Futbolísimos.',
    'https://www.todostuslibros.com/libros/los-futbolisimos-1-el-misterio-de-los-arbitros-dormidos_978-84-675-6135-7',
    false
  ),
  (
    9,
    'Beckman, Thea',
    null,
    null,
    '1973-01-01',
    'nobela',
    'Una emocionante novela de aventuras ambientada en la Edad Media. Imagina que la máquina del tiempo en la que viajas te transporta a un lugar que no deseas.Y que cuando estás a punto de conseguir volver a casa, una cruzada de niños se interpone en tu camino. Es exactamente lo que le sucede a Rudolf Hefting. Perdido en una época que no es la suya, no le queda más remedio que unirse a la expedición. En vaqueros, por supuesto.',
    'https://www.todostuslibros.com/libros/cruzada-en-jeans_978-84-9107-451-9',
    false
  ),
  (
    10,
    'Horikoshi, Kohei',
    'My Hero Academia',
    1,
    '2014-11-04',
    'manga',
    'Estamos en un mundo donde abundan los superhéroes (y los supervillanos). Los mejores humanos son entrenados en la Academia de Héroes para optimizar sus poderes.
Entre la minoría normal, sin poder alguno, aparece Izuku Midoriya, dispuesto a ser una excepción y formarse en la Academia.',
    'https://www.todostuslibros.com/libros/my-hero-academia-no-01_978-84-16693-50-4',
    false
  ),
  (
    11,
    'Vivanco Ramirez, Esibaliz; Larretxe Berazadi, Joseba',
    null,
    null,
    '2015-10-10',
    'nobela',
    'Eireren gurasoek Irlandan ezagutu zuten elkar, izugarri maite dute herrialde hura, eta hara bidaliko dute alaba udan, bere ingelesa hobetu dezan. Eirek ez du ingelesa maite, ordea, eta gogoz kontra ekingo dio bidaiari. Dena dela, uda luzean era guztietako esperientziak ezagutuko ditu Eirek: maitasuna, jeloskortasuna, porrotak eta arrakasta, baita poliziaren egoitzak ere...',
    'https://www.todostuslibros.com/libros/eireren-egunerokoa_978-84-9027-410-1',
    false
  ),
  (
    12,
    'Dahl, Roald',
    'Charlie Bucket',
    1,
    '1964-01-17',
    'nobela',
    'Charlie y la fábrica de chocolate es una historia de Roald Dahl, el gran autor de literatura infantil. El señor Wonka, dueño de la magnífica fábrica de chocolate, ha escondido cinco billetes de oro en sus chocolatinas. Quienes los encuentren serán los elegidos para visitar la fábrica. Charlie tiene la fortuna de encontrar uno de esos billetes y, a partir de ese momento, su vida cambiará para siempre.',
    'https://www.todostuslibros.com/libros/charlie-y-la-fabrica-de-chocolate-coleccion-alfaguara-clasicos_978-84-204-8288-0',
    false
  ),
  (
    13,
    'Frank, Anne',
    null,
    null,
    '1947-6-25',
    'nobela',
    'Tras la invasión de Holanda, los Frank, comerciantes judíos alemanes emigrados a Amsterdam en 1933, se ocultaron de la Gestapo en una buhardilla anexa al edificio donde el padre de Anne tenía sus oficinas. Ocho personas permanecieron recluidas desde junio de 1942 hasta agosto de 1944, fecha en que fueron detenidas y enviadas a campos de concentración. Desde su escondite y en las más precarias condiciones, Anne, una niña de trece años, escribió su estremecedor Diario: un testimonio único en su género sobre el horror y la barbarie nazi, y sobre los sentimientos y experiencias de la propia Anne y sus acompañantes. Anne murió en el campo de Bergen-Belsen en marzo de 1945. Su Diario nunca morirá.',
    'https://www.todostuslibros.com/libros/diario-de-anne-frank_978-84-663-5953-5',
    false
  ),
  (
    14,
    'Tolkien, J.R.R.',
    'El Señor de los Anillos',
    0,
    '1937-09-21',
    'nobela',
    'Smaug parecía profundamente dormido cuando Bilbo espió una vez más desde la entrada. ¡Pero fingía! ¡Estaba vigilando la entrada del túnel!... Sacado de su cómodo agujero-hobbit por Gandalf y una banda de enanos, Bilbo se encuentra de pronto en medio de una conspiración que pretende apoderarse del tesoro de Smaug el Magnífico, un enorme y muy peligroso dragón...',
    'https://www.todostuslibros.com/libros/el-hobbit_978-84-450-1394-6',
    false
  );
insert into etiqueta
values ('Fantasia', 1),
  ('Fantasia', 2),
  ('Fantasia', 3),
  ('Fantasia', 4),
  ('Fikzioa', 5),
  ('Fantasia', 6),
  ('Young Adult', 6),
  ('Fantasia', 7),
  ('Aventura', 7),
  ('Kirolak', 8),
  ('Young Adult', 9),
  ('Zientzia-fikzio', 9),
  ('Superheroiak', 10),
  ('Fantasia', 10),
  ('Irudiztatua', 11),
  ('Fantasia', 12),
  ('Umorea', 12),
  ('Biografia', 13),
  ('Historikoa', 13),
  ('Fantasia', 14);
insert into idiomas_libro
values (1, 'Gaztelania', 'El Camino de los Reyes'),
  (1, 'Ingelesa', 'The Way of Kings'),
  (2, 'Gaztelania', 'Palabras Radiantes'),
  (2, 'Ingelesa', 'Words of Radiance'),
  (3, 'Gaztelania', 'Juramentada'),
  (3, 'Ingelesa', 'Oathbringer'),
  (4, 'Gaztelania', 'El Ritmo de la Guerra'),
  (4, 'Ingelesa', 'Rhythm of War'),
  (5, 'Gaztelania', 'Malaherba'),
  (6, 'Gaztelania', 'Las Lágrimas de Shiva'),
  (
    7,
    'Gaztelania',
    'Harry Potter y la Piedra Filosofal'
  ),
  (
    7,
    'Ingelesa',
    "Harry Potter and the Philosopher's Stone"
  ),
  (
    8,
    'Gaztelania',
    'El Misterio de los Árbitros Dormidos'
  ),
  (9, 'Gaztelania', 'Cruzada en Jeans'),
  (9, 'Ingelesa', 'Crusade in Jeans'),
  (
    10,
    'Gaztelania',
    'My Hero Academia: Izuku Midoriya: Origen'
  ),
  (
    10,
    'Ingelesa',
    'My Hero Academia: Izuku Midoriya: Origin'
  ),
  (11, 'Euskara', 'Eireren Egunerokoa'),
  (
    12,
    'Gaztelania',
    'Charlie y la Fábrica de Chocolate'
  ),
  (12, 'Euskara', 'Charlie eta Txokolate-lantegia'),
  (
    12,
    'Ingelesa',
    'Charlie and the Chocolate Factory'
  ),
  (12, 'Frantsesa', 'Charlie et la Chocolaterie'),
  (13, 'Gaztelania', 'El Diario de Ana Frank'),
  (13, 'Euskara', 'Anne Franken Egunkaria'),
  (13, 'Ingelesa', 'The Diary of a Young Girl'),
  (13, 'Frantsesa', "Le Journal d'Anne Frank"),
  (14, 'Gaztelania', 'El Hobbit'),
  (14, 'Euskara', 'Hobbita'),
  (14, 'Ingelesa', 'The Hobbit'),
  (14, 'Frantsesa', 'Le Hobbit');
insert into review (
    id,
    nota,
    texto,
    edad_lector,
    nombre_idioma,
    id_libro,
    id_cuenta,
    aceptado
  )
values (
    1,
    4,
    'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Culpa quasi ipsum veritatis suscipit aperiam unde at modi officia accusantium porro?',
    20,
    'Gaztelania',
    1,
    3,
    true
  ),
  (
    2,
    1,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Non facilis modi repellat. Voluptas, amet? Minima.',
    10,
    'Euskara',
    1,
    4,
    true
  ),
  (
    3,
    2,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam nam voluptate provident, alias culpa cupiditate, animi obcaecati error autem aperiam nobis, iure temporibus blanditiis repudiandae fugit necessitatibus nostrum aliquid officiis incidunt eos laboriosam pariatur nulla? Lorem ipsum dolor sit amet consectetur adipisicing elit. Non facilis modi repellat. Voluptas, amet? Minima.',
    20,
    'Gaztelania',
    2,
    3,
    true
  ),
  (
    4,
    5,
    'Lorem ipsum dolor sit amet.',
    10,
    'Euskara',
    2,
    4,
    true
  ),
  (
    5,
    5,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam aperiam alias quos odit dicta fugiat similique dolorum adipisci laudantium eum cupiditate et praesentium, repudiandae repellat maiores debitis numquam iusto ut! Eum, tempore, sunt veritatis quas animi culpa debitis nesciunt doloremque repudiandae quasi tenetur fugit eaque repellendus esse illo molestias nisi ipsa facilis, quo explicabo possimus magni delectus. Facilis quos recusandae ipsam delectus earum totam veniam perferendis, fugiat molestiae saepe voluptatem officiis excepturi esse dolor explicabo.',
    20,
    'Gaztelania',
    3,
    3,
    true
  ),
  (
    6,
    5,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit officiis itaque adipisci, officia magni fugiat quam. Assumenda sequi expedita commodi saepe debitis rem eum totam obcaecati corporis at cumque eligendi quis minus adipisci dolor, in, porro explicabo aliquam modi similique! Atque, sapiente consequuntur.',
    10,
    'Euskara',
    3,
    4,
    true
  ),
  (7, 4, 'Lorem.', 20, 'Gaztelania', 4, 3, true),
  (
    8,
    5,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos molestiae enim dolorem veniam labore, magni officiis doloribus illo odit est, quaerat exercitationem dolore perferendis, quae repudiandae eum mollitia. Quos exercitationem, est expedita accusantium voluptates obcaecati ex inventore laborum nisi provident? Maxime harum unde nobis! Veniam minima accusamus quis omnis laudantium.',
    10,
    'Euskara',
    4,
    4,
    true
  );
insert into respuesta (id, texto, id_review, id_cuenta, aceptado)
values (
    1,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit accusamus aut nemo quas qui ipsa',
    1,
    5,
    true
  ),
  (
    2,
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea numquam quis, facilis pariatur qui facere exercitationem dolores repudiandae sapiente, nemo eum sequi amet',
    2,
    5,
    true
  ),
  (
    3,
    'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi saepe culpa ratione',
    8,
    2,
    true
  ),
  (
    4,
    'Lorem, ipsum dolor',
    8,
    4,
    true
  );