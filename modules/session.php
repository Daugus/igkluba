<?php
function checkSession(): void
{
  session_start();
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];
  ob_start();
  if (!isset($_SESSION['usr'])) {
    header('Location: /hasi');
  }
}

function checkLogin(): void
{
  session_start();
  if (isset($_SESSION['usr'])) {
    header('Location: /nagusia');
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
  header('Location: /hasiera');
}

function agregarSelectColumnas(): void
{
?>
  <div class="flex-center-row" id="select-columnas">
    <label for="select-columnas">Zutabe kopuruaren muga:</label>

    <div class="select-container">
      <select name="columnas" id="columnas">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>
    </div>
  </div>

<?php
}
