<?php
session_start();
require_once('dao/dataDAO.php');

?>

<?php


$statusMsg = '';

// File upload path
$targetDir = 'uploads/';
$fileName = basename($_FILES["fileToUpload"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
			
			  if(isset($_POST["imageForUser"]))
			  //if($_POST['imageForUser'] != null) 
			  {
				$username=$_POST["imageForUser"];
			  }
			else	
			{
				$username=$_SESSION["username"];
			}
			
			$link = db_connect();
	        $insert = $link->query("INSERT into images (file_name, uploaded_on, username) VALUES ('".$fileName."', NOW(),'".$username."' )" ); 
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;

?>

<button id="backbtn"  onclick="javascript:window.history.go(-1);return false;">BACK</button>








