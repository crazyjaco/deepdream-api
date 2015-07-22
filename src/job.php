#!/usr/bin/php
<?php
require_once 'api/inc/db.php';
$db = $m->deepdreamapi;
$collection = $db->dreams;

$cursor = $collection->find(array(), array('_id' => 0));
foreach($cursor as $result){
	print_r($result);
}
