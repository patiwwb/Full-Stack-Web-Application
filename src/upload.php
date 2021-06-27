<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    require_once "config.php";
?>

<?php 

  if(isset($_GET['u']))
  {
      $get_admin = htmlspecialchars($_GET['u']);
      
      $decoded_token = base64_decode($get_admin);

  }
  else
  {
      header('Location: index.php'); 
  }

?>

<?php 

if (isset($_POST['submit-files']) && isset($_FILES['my_image'])) {

	echo "<pre>";
	print_r($_FILES['my_image']);
	echo "</pre>";

	$img_name = htmlspecialchars($_FILES['my_image']['name']);
	$img_size = htmlspecialchars($_FILES['my_image']['size']);
	$tmp_name = htmlspecialchars($_FILES['my_image']['tmp_name']);
	$error = htmlspecialchars($_FILES['my_image']['error']);


	if ($error === "0") {
		if ($img_size > 125000) {
			$em = "Sorry, your file is too large.";
		    header("Location: app.php?u=$get_admin&error=$em");
		}else {
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'uploads/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);

				$insert = $bdd->prepare('INSERT INTO images (image_url,owner) VALUES (?,?);');
				$insert->execute(array($new_img_name,$decoded_token));
				echo("successfully uploaded");
				header("Location: app.php?u=$get_admin&success=true");
				die();
				
			}else {
				$em = "You can't upload files of this type";
		        header("Location: index.php?error=$em");
				die();
			}
		}
	}else {
		$em = "unknown error occurred!";
		header("Location: app.php?u=$get_admin&error=$em");
		die();
	}
    
}else {
	header("Location: app.php?u=$get_admin");
	die();
}