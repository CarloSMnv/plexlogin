<?php
    session_start();
    require_once "config.php"; 
    if (empty($_SESSION["userid"])) {
        header("Location: login.php");
        exit;
    }
    
    $stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION["userid"]]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        header("Location: login.php");
        exit;
    }
    $requiredRole = 'usuario'; // Definir el rol requerido para acceder a la página o función
    
    // Obtener el rol del usuario desde la sesión
    $userRole = $_SESSION['roles'][0];
    
    if ($userRole !== $requiredRole) {
        // Mostrar un mensaje de acceso denegado o redirigir a una página de error
        echo "Acceso denegado. No tienes permisos suficientes para acceder a esta página.";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido <?php echo $user['name']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Hola, <strong><?php echo $user['name']; ?></strong>. <br> Bienvenido a tu sitio </br></h1>
            </div>
            <p>
                <a href="cerrarSesion.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Cerrar sesión</a>
            </p>
        </div>
    </div>
</body>
</html>
