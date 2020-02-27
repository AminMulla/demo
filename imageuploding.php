<?php
	include 'db.php';
	$base_url ="http://www.technogreen.co.in/AndroidApp/imagess/";
	//get data
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	
	//itarate data by json
	$catagoery = $data->category;
	$subcatagoery = $data->subCategory;
	$subject =	$data->subject;
	$discription = $data->description;
	$email = $data->email;
	$phonenumber = $data->phone;
	$city = $data->city;
	$address = $data->detailAddress;
	$subregion = $data->subRegion;

	
	if($city == 'Thane'){
		$sqldata = "SELECT emailid,refno FROM sro_list WHERE district = '".$city."' AND mpcb_region = '".$subregion."'";
	}else{
		$sqldata = "SELECT emailid,refno FROM sro_list WHERE district = '".$city."'";
	}
	
	$resultdata = mysqli_query($con,$sqldata);
	while($row = mysqli_fetch_assoc($resultdata)){
		$refNumber = $row['refno'];
		$sendEmail = $row['emailid'];
	}
	
	//get current time server 
	$currentTime = time();
	$compalintref = "MPCB".$refNumber."CGS".$currentTime;
	
	//get image encoded to decoded
	$image_name = $currentTime.".png";
	$img =  base64_decode($data->image);
	
	//copy and write file from folder
   if( $file = fopen("imagess/".$image_name, 'wb')){
            fwrite($file, $img);
            fclose($file);
			//echo "add file";
	}
	$sql = "INSERT INTO complaint  (user_email,user_contact,subject,category,sub_category,description,district,sub_region,address,image,ref_no,c_ref_no) 
	VALUES ('".$email."','".$phonenumber."','".$subject."','".$catagoery."','".$subcatagoery."','".$discription."','".$city."','".$subregion."','".$address."','".$image_name."','".$refNumber."','".$compalintref."')";
					$result = mysqli_query($con,$sql);
					
					$mail_body = $catagoery."\n".$subcatagoery."\n\n".$discription."\n\n Image url:".$base_url.$image_name;
					
			writeMsg($email,$subject,$mail_body,$sendEmail);
   function writeMsg($email,$subject,$mail_body,$sendEmail){
	    $to = $sendEmail;
		$subject = $subject;
		$txt = $mail_body;
		$headers = "From: ".$email;
       // echo $subject;
		mail($to,$subject,$txt,$headers);
   }
		if($result){
			echo $compalintref;
		}else{ echo 'NO Add Data'.mysqli_error($con);}
	
?>