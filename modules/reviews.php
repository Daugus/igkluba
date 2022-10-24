<?php

function buscarReviews(int $id, array $condiciones): array
{
  include '../modules/db-config.php';
  $reviews = $pdo->prepare(
    'SELECT r.id, r.nota, r.texto, r.edad_lector, r.nombre_idioma, r.id_cuenta, r.id_libro, c.id AS id_cuenta, c.nombre, c.apellido, c.apodo, c.rol
      FROM review r JOIN cuenta c ON r.id_cuenta = c.id
      WHERE ' . implode(' AND ', $condiciones) . ';'
  );
  $reviews->execute(['id' => $id]);
  $reviews = $reviews->fetchAll();

  return $reviews;
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
