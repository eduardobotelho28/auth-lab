<?php
echo '<pre>';
echo "Host: " . $_SERVER['HTTP_HOST'] . PHP_EOL;
echo "Porta: " . $_SERVER['SERVER_PORT'] . PHP_EOL;
echo "URL completa: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . PHP_EOL;
echo '</pre>';