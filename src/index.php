<?php
require 'vendor/autoload.php';
require 'Database/Connection.php';

use App\Database\Connection;

$connection = new Connection();
$connection->connect();