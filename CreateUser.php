<?php
require_once "session.php"; 
if(isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
	include('conexion/config.php');
	$email = trim($_REQUEST['email']);
	$password = trim($_REQUEST['password']);
	$name = filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);
	$captcha = $_POST['g-recaptcha-response'];

	// Verifica si la respuesta del Recaptcha está vacía
	if (!$captcha) {
	    echo "Por favor, verifica que no eres un robot";
	} else {
	    $secretkey = "6LfBidMlAAAAAJwALJcFea2ONJfjGhDumcXAbroh";
	    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha");
	    $atributos = json_decode($respuesta, TRUE);

	    if(!isset($atributos['success']) || $atributos['success'] !== true) {
	        // El captcha no se ha validado correctamente
	        echo "Por favor, verifica que no eres un robot";
	    } else {
	        // El captcha se ha validado correctamente
	        // Continuar con el código para validar la cuenta de usuario
			function TokenAleatorio($length = 50) {
			    return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
			}
			$miToken  = TokenAleatorio();

			$PasswordHash = password_hash($password, PASSWORD_BCRYPT);

			$SqlVerificandoEmail = ("SELECT email FROM users WHERE email COLLATE utf8mb4_bin='$email'");
			$jqueryEmail         = mysqli_query($con, $SqlVerificandoEmail); 
			if(mysqli_num_rows($jqueryEmail) >0){
				
			}else{
				$queryInsertUser  = ("INSERT INTO users(email,password, name) VALUES ('$email','$PasswordHash','$name')");
				$resultInsertUser = mysqli_query($con, $queryInsertUser);
				header("location: index.php");
			}
	    }
	}
}
?>

