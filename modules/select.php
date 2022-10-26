<?php

function buscarLibros(String $condicion, String $orden = 'l.nota_media DESC', bool $aceptado = true, bool $esProfesor = true): array
{
  $aceptado = $aceptado ? 1 : 0;
  include '../modules/db-config.php';
  $libros = $pdo->prepare('SELECT DISTINCT l.id, il.titulo_alternativo AS titulo, l.autor, l.nota_media
  FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro
  WHERE ' . $condicion
    . ' AND l.aceptado = ' . $aceptado
    . ' GROUP BY l.id'
    . ' ORDER BY ' . $orden
    . ' LIMIT 24;');
  $libros->execute();

  return $libros->fetchAll();
}

function agregarLibros(array $libros): void
{
  foreach ($libros as $libro) {
    $url = '/liburua/' . $libro['id'] . '-' . str_replace(' ', '_', strtolower($libro['titulo']));
?>
    <article class="flex-space-between-col libro">
      <a href="<?php echo $url ?>" class="libro__portada">
        <img src="/src/img/azala/<?php echo $libro['id'] ?>.png" alt="Portada <?php echo $libro['titulo'] ?>">
      </a>

      <div class="flex-center-col libro__texto">
        <a href="<?php echo $url ?>" class="libro__titulo">
          <?php echo $libro['titulo'] ?>
        </a>

        <a href="/#<?php echo $libro['autor'] ?>" class="libro__autor">
          <?php echo $libro['autor'] ?>
        </a>

        <a href="<?php echo $url ?>#iritziak" class="nota libro__nota">
          <?php
          if ($libro['nota_media'] > 0) {
            echo number_format((float)$libro['nota_media'], 2, '.', '');
          } else {
            echo '-';
          }
          ?><i class="fa-solid fa-star"></i>
        </a>
      </div>
    </article>
  <?php
  }
}

function buscarSolicitudesLibros(array $usuario): array
{
  include '../modules/db-config.php';
  if ($usuario['rol'] === 'Admin') {
    $libros = $pdo->prepare(
      'SELECT DISTINCT l.id, il.titulo_alternativo AS titulo, l.autor, l.nota_media
        FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro
        WHERE l.aceptado = 0
        GROUP BY l.id
        ORDER BY il.id_idioma ASC, titulo ASC
        LIMIT 24;'
    );
  } else {
    $clases = $pdo->prepare('SELECT * FROM profesor_clase WHERE id_profesor = :id');
    $clases->execute(['id' => $usuario['id']]);
    $clases = array_column($clases->fetchAll(), 'cod_clase');

    $clases = implode(', ', array_map(function ($clase) {
      return "'$clase'";
    }, $clases));

    $libros = $pdo->prepare(
      "SELECT DISTINCT l.id, il.titulo_alternativo AS titulo, l.autor, l.nota_media
        FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro
        WHERE l.aceptado = 0
          AND l.id in (SELECT sl.id_libro
                        FROM solicitud_libro sl JOIN cuenta c ON sl.id_alumno = c.id
                        WHERE c.cod_clase IN ($clases))
        GROUP BY l.id
        ORDER BY il.id_idioma ASC, titulo ASC
        LIMIT 24;"
    );
  }

  $libros->execute();
  return $libros->fetchAll();
}

function agregarSolicitudesLibros(array $solicitudesLibros): void
{
  ?>
  <section>
    <h2 id="eskaerak">Liburu eskaerak</h2>
    <div class="grid-libros">
      <?php
      foreach ($solicitudesLibros as $libro) {
      ?>
        <article class="flex-space-between-col libro">
          <img src="/src/img/azala/<?php echo $libro['id'] ?>.png" alt="Portada <?php echo $libro['titulo'] ?>">

          <div class="flex-center-col libro__texto">
            <p class="libro__titulo" title="<?php echo $libro['titulo'] ?>">
              <?php echo $libro['titulo'] ?>
            </p>

            <a href="/#<?php echo $libro['autor'] ?>" class="libro__autor">
              <?php echo $libro['autor'] ?>
            </a>
          </div>
          <a href="/liburua/<?php echo $libro['id'] ?>/eskaera" class="btn">Eskaera ikusi</a>
        </article>
      <?php
      }
      ?>
    </div>
  </section>
<?php
}

function buscarReviews(int $id, array $condiciones): array
{
  include '../modules/db-config.php';
  $reviews = $pdo->prepare(
    'SELECT r.id, r.nota, r.texto, r.edad_lector, r.nombre_idioma, r.id_cuenta, r.id_libro, c.id AS id_cuenta, c.nombre, c.apellido, c.apodo, c.rol
      FROM review r JOIN cuenta c ON r.id_cuenta = c.id
      WHERE ' . implode(' AND ', $condiciones) . ';'
  );
  $reviews->execute(['id' => $id]);

  return $reviews->fetchAll();
}

function agregarReviews(array $reviews, bool $seccionPersonal = false): void
{
  include '../modules/db-config.php';
?>
  <section id="opiniones">
    <h2 id="iritziak">Iritziak:</h2>

    <div class="flex-stretch-col" id="reviews">
      <?php foreach ($reviews as $review) { ?>
        <article class="flex-stretch-col review">
          <div>
            <?php
            if ($seccionPersonal) {
              $tituloLibro = $pdo->prepare('SELECT titulo_alternativo AS titulo FROM idiomas_libro WHERE id_libro = :id_libro;');
              $tituloLibro->execute(['id_libro' => $review['id_libro']]);
              $tituloLibro = $tituloLibro->fetch()['titulo'];
            ?>
              <h3 class="titulo-libro"><a href="/liburua/<?php echo $review['id_libro'] ?>"><?php echo $tituloLibro ?></a></h3>
            <?php
            } else {
            ?>
              <h3>
                <?php
                echo $review['apodo'];
                if ($_SESSION['usr']['rol'] !== 'Ikasle') {
                  echo ' (' . $review['nombre'] . ' ' . $review['apellido'] . ')';
                }
                ?>:
              </h3>
            <?php
            }
            ?>
            <p><?php echo $review['texto'] ?></p>
            <p class="nota"><?php echo $review['nota'] ?><i class="fa-solid fa-star"></i></p>
            <p><span>Adina:</span> <?php echo $review['edad_lector'] ?></p>
            <?php
            $cantidadRespuestas = $pdo->prepare('SELECT count(id) AS cantidad_respuestas FROM respuesta WHERE id_review = :id_review;');
            $cantidadRespuestas->execute(['id_review' => $review['id']]);
            $cantidadRespuestas = $cantidadRespuestas->fetch()['cantidad_respuestas'];
            if ($cantidadRespuestas > 0) {
            ?>
              <a href="/iritzia/<?php echo $review['id'] ?>" class="ver-respuestas">
                Erantzunak (<?php echo $cantidadRespuestas ?>)
              </a>
            <?php
            }
            ?>
          </div>

          <div class="flex-stretch-row">
            <?php if (!$seccionPersonal) { ?>
              <a href="/iritzia/<?php echo $review['id'] ?>/erantzun" class="btn">Erantzun</a>
            <?php
            }
            ?>

            <?php if ($seccionPersonal || $review['id_cuenta'] === $_SESSION['usr']['id']) { ?>
              <a href="/iritzi/<?php echo $review['id'] ?>/aldatu" class="btn">Iritzia aldatu</a>
              <a href="/iritzi/<?php echo $review['id'] ?>/ezabatu" class="btn">Iritzia ezabatu</a>
            <?php
            }
            ?>
          </div>
        </article>
      <?php
      }
      ?>
    </div>
  </section>
<?php
}