<?php
function agregarHead(String $title = 'IGKluba', String $archivoJS = '')
{
  include_once '../modules/url.php';
  $url = getUrl();
?>

  <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />

    <title><?php echo $title ?></title>

    <link rel='stylesheet' href='<?php echo $url ?>/src/style.css' />
    <?php
    if (!empty($archivoJS)) {
    ?>
      <script src='src/js/<?php echo basename("$archivoJS", '.php') ?>.js' defer></script>
    <?php
    }
    ?>
  </head>

<?php } ?>