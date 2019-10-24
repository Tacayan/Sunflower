<?php
require 'ex.class.php';
require 'connection.php';

$ex = new ex();

$ex->registerEx($_GET['name']);