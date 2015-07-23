#!/usr/bin/php
<?php
set_time_limit(0);
$guide = '/home/ubuntu/images/doge.jpg'; // temporary guide until I factor it in as an API argument
require_once 'api/inc/db.php';
$db = $m->deepdreamapi;
$collection = $db->dreams;

$cursor = $collection->find(array(), array('_id' => 0));
foreach($cursor as $results){
	foreach($results as $result){
		$dream_id = $result['dream_id'];
		$file_ext = escapeshellarg($result['file_type']);
		$input = escapeshellarg($result['file_name']);
		$output = '/opt/deepdream-api/dream/' . $dream_id . "." . $file_ext;
		if(!file_exists($output)){
			print "Dreaming $dream_id\n";
			shell_exec("/usr/bin/python /opt/deepdream-api/src/dream.py $guide $input $output 2>/dev/null &");
		}
	}
}



