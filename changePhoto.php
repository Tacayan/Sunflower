<?php

require 'ex.class.php';
require 'connection.php';

$changePhoto = new ex();
$changePhoto->addPhoto($_POST['codEx']);
