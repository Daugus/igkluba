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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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