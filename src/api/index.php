<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();

$app->notFound(function () use ($app) {
	$app = \Slim\Slim::getInstance();
	$app->response->setStatus(404);
	print "404 - Not Found";
});

$app->post('/upload', function(){
	$target = __DIR__ . "/input/"; 
	if($_FILES){
		$target = $target . basename($_FILES['upload']['name']);
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
 
	if($ok==0){ 
		print '<form enctype="multipart/form-data" action="" method="POST">
	        <input name="upload" type="file" /><input type="submit" value="Upload" />
	 </form>';
	} else {
	        $app = \Slim\Slim::getInstance();
	        $app->response()->headers->set('Content-Type', 'application/json');
		if(move_uploaded_file($_FILES['upload']['tmp_name'], $target)){ 
			require_once __DIR__ . "/inc/db.php";
			$db = $m->deepdreamapi;
			$collection = $db->dreams;
			$dream_id = md5(base64_encode(rand()));
			$file_md5 = md5_file($target);
			rename($target, __DIR__ . "/input/" . "$file_md5.$file_ext");
			$target = "$file_md5.$file_ext";
			$data = array(
				$dream_id => array("status" => "queued",
					"dream_id" => "$dream_id",
					"uploaded" => time(),
					"file_md5" => md5_file(__DIR__ . "/input/" . "$file_md5.$file_ext"),
					"file_type" => "$file_ext",
					"file_size" => $_FILES['upload']['size'],
					"file_name" => "$target"));
			$collection->insert($data);
			print json_encode($data, JSON_PRETTY_PRINT);
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
