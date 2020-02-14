<?php

    //$name = $_REQUEST['name'];
	//echo  "xdfvsd ".$name;
	
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	//$array = get_object_vars($obj);
	
	$name = $data->name;
	echo $name;
	/*$catagoery =
	$subcatagoery =
	$subject =
	$discription =
	$email =
	$phonenumber =
	$lat =
	$long =
	$diveceId =
	$city =
	$subregion =*/
	$img =  base64_decode($data->image);
	
	$currentTime = time();
   $image_name = $currentTime.".jpg";
   if( $file = fopen("images/".$image_name, 'wb')){
            fwrite($file, $img);
            fclose($file);
			echo "add file";
	}
 
   function writeMsg(){
	    $to = "aminmulla00@gmail.com";
		$subject = "My subject";
		$txt = "Hello i m amin mulla!";
		$headers = "From: amin.mulla0302@gmail.com";

		mail($to,$subject,$txt,$headers);
   }
 
?>