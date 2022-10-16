<?php
function checkSession(): void
{
  session_start();
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];
  ob_start();
  if (!isset($_SESSION['usr'])) {
    header('Location: hasi');
  }
}

function checkLogin(): void
{
  session_start();
  if (isset($_SESSION['usr'])) {
    header('Location: nagusia');
  }
}

function saveSession(array $usr): void
{
  session_start();
  $_SESSION['usr'] = $usr;
}

function closeSession(): void
{
  session_start();
  session_unset();
  header('Location: hasiera');
}
