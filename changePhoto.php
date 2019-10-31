<?php

require 'ex.class.php';
require 'connection.php';

$changePhoto = new ex();

$changePhoto->addPhoto($_POST['codEx'], $_POST['url']);
var_dump(error_get_last());