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
    'Anhelo los días previos a la Última Desolación. Los días en que los Heraldos nos abandonaron y los Caballeros Radiantes se giraron en nuestra contra. Un tiempo en que aún había magia en el mundo y honor en el corazón de los hombres. El mundo fue nuestro, pero lo perdimos. Probablemente no hay nada más estimulante para las almas de los hombres que la victoria. ¿O tal vez fue la victoria una ilusión durante todo ese tiempo? ¿Comprendieron nuestros enemigos que cuanto más duramente luchaban, más resistíamos nosotros? Quizá vieron que el fuego y el martillo tan solo producían mejores espadas. Pero ignoraron el acero durante el tiempo suficiente para oxidarse. Hay cuatro personas a las que observamos. La primera es el médico, quien dejó de curar para convertirse en soldado durante la guerra más brutal de nuestro tiempo. La segunda es el asesino, un homicida que llora siempre que mata. La tercera es la mentirosa, una joven que viste un manto de erudita sobre un corazón de ladrona. Por último está el alto príncipe, un guerrero que mira al pasado mientras languidece su sed de guerra. El mundo puede cambiar. La potenciación y el uso de las esquirlas pueden aparecer de nuevo, la magia de los días pasados puede volver a ser nuestra. Esas cuatro personas son la clave.',
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
  ),
  (
    3,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    3,
    '2017-11-14',
    'nobela',
    'La humanidad se enfrenta a una nueva Desolación con el regreso de los Portadores del Vacío, un enemigo tan grande en número como en sed de venganza. La victoria fugaz de los ejércitos alezi de Dalinar Kholin ha tenido consecuencias: el enemigo parshendi ha convocado la violenta tormenta eterna, que arrasa el mundo y hace que los hasta ahora pacíficos parshmenios descubran con horror que llevan un milenio esclavizados por los humanos. Al mismo tiempo, en una desesperada huida para alertar a su familia de la amenaza, Kaladin se pregunta si la repentina ira de los parshmenios está justificada. Entretanto, en la torre de la ciudad de Urithiru, a salvo de la tormenta, Shallan Davar investiga las maravillas de la antigua fortaleza de los Caballeros Radiantes y desentierra oscuros secretos que acechan en las profundidades. Dalinar descubre entonces que su sagrada misión de unificar su tierra natal de Alezkar era corta de miras. A menos que todas las naciones sean capaces de unirse y dejar de lado el pasado sangriento de Dalinar, ni siquiera la restauración de los Caballeros Radiantes conseguirá impedir el fin de la civilización.',
    'https://www.todostuslibros.com/libros/juramentada-el-archivo-de-las-tormentas-3_978-84-17347-00-0'
  ),
  (
    4,
    'Sanderson, Brandon',
    'El Archivo de las Tormentas',
    4,
    '2020-11-17',
    'nobela',
    'Hay secretos que hemos guardado mucho tiempo. Vigilantes. Insomnes. Eternos. Y pronto dejarán de ser nuestros. La Una que es Tres busca, sin saberlo, el alma capturada. El spren aprisionado, olvidado hace mucho tiempo. ¿Puede liberar su propia alma a tiempo de hallar el conocimiento que condena a todos los pueblos de Roshar? El Soldado Caído acaricia y ama la lanza, incluso mientras el arma hiende su propia carne. Camina siempre hacia delante, siempre hacia la oscuridad, sin luz. No puede llevar consigo a nadie, salvo aquello que él mismo puede avivar. La Hermana Derrumbada comprende sus errores y piensa que ella misma es un error. Parece muy alejada de sus antepasados, pero no comprende que son quienes la llevan a hombros. Hacia la victoria, y hacia ese silencio, el más importante de todos. Y la Madre de Máquinas, la más crucial de todos ellos, danza con mentirosos en un gran baile. Debe desenmascararlos, alcanzar sus verdades ocultas y entregarlas al mundo. Tiene que reconocer que las peores mentiras son las que se cuenta a sí misma. Si lo hace, nuestros secretos por fin se convertirán en verdades.',
    'https://www.todostuslibros.com/libros/el-ritmo-de-la-guerra-el-archivo-de-las-tormentas-4_978-84-17347-93-2'
  );
insert into etiqueta
values ('Fantasia', 1),
  ('Fantasia', 2),
  ('Fantasia', 3),
  ('Fantasia', 4);
insert into idiomas_libro
values (1, 'Gaztelania', 'El Camino de los Reyes'),
  (1, 'Ingelesa', 'The Way of Kings'),
  (2, 'Gaztelania', 'Palabras Radiantes'),
  (2, 'Ingelesa', 'Words of Radiance'),
  (3, 'Gaztelania', 'Juramentada'),
  (3, 'Ingelesa', 'Oathbringer'),
  (4, 'Gaztelania', 'El Ritmo de la Guerra'),
  (4, 'Ingelesa', 'Rhythm of War');
insert into review (
    id,
    nota,
    texto,
    edad_lector,
    nombre_idioma,
    id_libro,
    id_cuenta
  )
values (1, 4, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Culpa quasi ipsum veritatis suscipit aperiam unde at modi officia accusantium porro?', 20, 'Gaztelania', 1, 3),
  (2, 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Non facilis modi repellat. Voluptas, amet? Minima.', 10, 'Euskara', 1, 4),
  (3, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam nam voluptate provident, alias culpa cupiditate, animi obcaecati error autem aperiam nobis, iure temporibus blanditiis repudiandae fugit necessitatibus nostrum aliquid officiis incidunt eos laboriosam pariatur nulla? Lorem ipsum dolor sit amet consectetur adipisicing elit. Non facilis modi repellat. Voluptas, amet? Minima.', 20, 'Gaztelania', 2, 3),
  (4, 5, 'Lorem ipsum dolor sit amet.', 10, 'Euskara', 2, 4),
  (5, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam aperiam alias quos odit dicta fugiat similique dolorum adipisci laudantium eum cupiditate et praesentium, repudiandae repellat maiores debitis numquam iusto ut! Eum, tempore, sunt veritatis quas animi culpa debitis nesciunt doloremque repudiandae quasi tenetur fugit eaque repellendus esse illo molestias nisi ipsa facilis, quo explicabo possimus magni delectus. Facilis quos recusandae ipsam delectus earum totam veniam perferendis, fugiat molestiae saepe voluptatem officiis excepturi esse dolor explicabo.', 20, 'Gaztelania', 3, 3),
  (6, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit officiis itaque adipisci, officia magni fugiat quam. Assumenda sequi expedita commodi saepe debitis rem eum totam obcaecati corporis at cumque eligendi quis minus adipisci dolor, in, porro explicabo aliquam modi similique! Atque, sapiente consequuntur.', 10, 'Euskara', 3, 4),
  (7, 4, 'Lorem.', 20, 'Gaztelania', 4, 3),
  (8, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos molestiae enim dolorem veniam labore, magni officiis doloribus illo odit est, quaerat exercitationem dolore perferendis, quae repudiandae eum mollitia. Quos exercitationem, est expedita accusantium voluptates obcaecati ex inventore laborum nisi provident? Maxime harum unde nobis! Veniam minima accusamus quis omnis laudantium.', 10, 'Euskara', 4, 4);
insert into respuesta
values (1, 'respuesta a bien', 1, 5),
  (2, 'respuesta a mal', 2, 5);