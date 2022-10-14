<?php
function getUrl(): string
{
  return 'http://' . $_SERVER['HTTP_HOST'];
}

function getPage(): array
{
  $url = parse_url($_SERVER['REQUEST_URI']);
  return array_slice(array_filter(explode('/', $url['path'])), 0);
}
