<?php
$m = new MongoClient("localhost");
$db = $m->deepdreamapi;
$collection = $db->queue;
