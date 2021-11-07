<?php 

$app = require_once __DIR__.'/src/Kernel.php';

return $app->processRequest($_SERVER);


