<?php
function agregarHead(String $title = 'IGKluba', String $archivoJS = '')
{
?>

  <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />

    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="/src/img/favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='/src/style.css' />
    <script src='/src/js/compartido.js' defer></script>

    <?php if (!empty($archivoJS)) { ?>
      <script src='/src/js/<?php echo basename("$archivoJS", '.php') ?>.js' defer></script>
    <?php
    }
    ?>
  </head>

<?php } ?>