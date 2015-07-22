<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();

$app->notFound(function () use ($app) {
	$app = \Slim\Slim::getInstance();
	$app->response->setStatus(404);
	print "404 - Not Found";
});

$app->post('/upload', function(){
	$target = "uploads/"; 
	if($_FILES){
		$target = $target . basename( $_FILES['upload']['name']);
	}
	$file_ext = pathinfo($target,PATHINFO_EXTENSION);
	$ok=1;
	 //This is our limit file type condition 
	if($file_ext == 'jpg'){ 
		$ok=1;
	} elseif($file_ext == 'png'){
	        $ok=1;
	} else {
		$ok=0;
	}
 
	 //Here we check that $ok was not set to 0 by an error 
	if($ok==0){ 
		print '<form enctype="multipart/form-data" action="" method="POST">
	        <input name="upload" type="file" /><input type="submit" value="Upload" />
	 </form>';
	} else {
	        $app = \Slim\Slim::getInstance();
	        $app->response()->headers->set('Content-Type', 'application/json');
		if(move_uploaded_file($_FILES['upload']['tmp_name'], $target)){ 
			require_once "inc/db.php";
			$db = $m->deepdreamapi;
			$collection = $db->queue;
			$dream_id = md5(base64_encode(rand()));
			print json_encode(array(
				$dream_id => array("status" => "queued",
					"dream_url" => "http://$_SERVER[HTTP_HOST]" . "/dream/$dream_id.$file_ext",
					"uploaded" => time(),
					"file_type" => "$file_ext",
					"file_size" => $_FILES['upload']['size'],
					"file_orig" => "http://$_SERVER[HTTP_HOST]" . "/" .$target,
					"file_name" => $target)),
					JSON_PRETTY_PRINT);
		} else { 
			print json_encode(array("status" => "error"), JSON_PRETTY_PRINT);
		}
	}
});

$app->get('/upload', function(){
	                print '<form enctype="multipart/form-data" action="" method="POST">
                <input name="upload" type="file" /><input type="submit" value="Upload" />
         </form>';
});
$app->run();
