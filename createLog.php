<?php
require 'log.class.php';
require 'connection.php';

$log = new log();

$log->createLog($_GET['log'], $_GET['codEx'], $_GET['url']);