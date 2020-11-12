<?php
session_start();
require_once('dao/dataDAO.php');
$link = db_connect();
if (isset($_SESSION["adminname"])) {
    $username = $_SESSION["adminname"];
    session_write_close();
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
}

?>



<style>
    html,
    body {
        height: 100%;
    }

    body {
        background: #FFFF;

        color: #fff;
        font-size: 1.5em;
        font-weight: 400;
        text-align: right;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }



.main {
        position: relative;
        background: #ffffff;
        color: #0e5698;
        display: inline-block;
        padding: 15px 30px;
        margin: 0 auto;
        min-height: 250px;
        min-width: 400px;
    }





    h1 {
        font: 30px sans-serif;
        text-align: center;
        margin: 25px 10px;
        font-weight: bold;
        color: #000000;

    }





h2 {
        font: 20px sans-serif;
        text-align: center;
        margin: 25px 10px;
        font-weight: bold;
        color: #000000;

    }



    input,
    button,
    select,
    textarea {
        display: block;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 10px;
        line-height: 28px;
        height: 30px;
        padding: 0 10px;
        width: 100%;
        box-sizing: border-box;
        font-family: sans-serif;
        font-size: 15px;
    }

    button {
        background: #228B22;
        color: #fff;
        line-height: 40px;
        height: 40px;
        font-size: 18px;
        border: 0;
    }

    button:hover {
        opacity: 0.7;
        cursor: pointer;
    }
    </style>
<HTML>
<HEAD>
<TITLE>Welcome</TITLE>
</HEAD>
<BODY>
   <div class='main'>
  <div id="process"> 
  <div class="logout"></div>
<h1>Welcome  Admin!</h1>
 
  <form action="upload.php" enctype="multipart/form-data" method="post"><h2>Select image to upload:</h2>
  <input id="fileToUpload" name="fileToUpload" type="file" />
  <br /><center>For User : 
	  
  <select id="imageForUser" name="imageForUser">

	  <?php
	  //SELECT * FROM tbl_member where username
 	$query="SELECT * FROM tbl_member ";
	  //echo $query;
	  
	  $result = db_query($link, $query);
		while ($row = db_fetch_assoc($result))
		{
			echo "<option>".$row["username"]."</option>";
		}
	 ?>
  
  </select>
  
  <button type="submit" name="submit">Upload Image</button>
  <!--<form action="" name = "logout" method="post">  [20201111]-->
          <a href = login.php > Log out </a>
  </form>
    
	   <h2 >List of Images </h2>
<?php
	  
	  
 	$query="SELECT * FROM images ORDER BY uploaded_on DESC";
	  //echo $query;
	  
	  $result = db_query($link, $query);
		while ($row = db_fetch_assoc($result))
		{
	
        $imageURL = 'uploads/'.$row["file_name"];
		?>
		<img height="150" src="<?php echo $imageURL; ?>" alt="" />
		<?php 
			echo "<br><h5><center> user: ".$row["username"]."<br> on ".$row["uploaded_on"]." </center></h5><hr>";
		}
	 
	   db_close($link);
	   ?>

  
  </div>

</BODY>
</HTML>
