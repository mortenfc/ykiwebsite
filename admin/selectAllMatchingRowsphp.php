<?php
// require_once 'consolejs.php';
require_once '../config.php';

$sql = "SELECT dates, name, email FROM appointments WHERE dates LIKE '" .  . "%' ORDER BY dates";