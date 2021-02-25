<?php 

    session_start();
    $error=0;
    $usuario=array();
    $veces=1;

    // si existe la variable se sesión veces la incremento y la guardo para usarla
    if(isset($_SESSION['veces'])){
        $veces=$_SESSION['veces'];
        $veces++;
    }

    if(isset($_GET['logout'])){
        $veces=1;
        $_SESSION['veces']=$veces;
        session_unset();
    }

    if(isset($_GET['error'])){
        $error=2;
    }


    // si se ha iniciado sesión 5 veces o más se bloqueara el inicio y se pone la variable error a 3 para luego indicarlo
    if($veces>5){
        $error=3;
    }
    else if(isset($_POST['email']) && isset($_POST['pass']) ){
        
        if( strcmp($_POST['email'], 'perezleon.miguel') === 0 && strcmp($_POST['pass'], '1234') === 0 ){
            // si el email y la contraseña son correctos se guardan los datos en la sesión y se pone a 0 las veces que se ha intentado iniciar sesión
            $usuario['email']= $_POST['email'];
            $usuario['pass']= $_POST['pass'];

            $_SESSION['usuario']=$usuario;

            $veces=0;
            $_SESSION['veces']=$veces;

            header('Location: principal.php');
            
            die (); 
        }
        // si el email de usuario no coincide se pone el error a 1
        else{
            $error=1;

            //guardo en un fichero de logs que se ha intentado hacer inicio de sesión en el sitio
            $log= sprintf("%s , <status> login failed <status>. \n", date("Y-m-d H:i:s"), $_POST['email']);
            $fp = fopen('resources/logs/log_login.txt', 'c+');
            fseek($fp, 0,  SEEK_END);
            fwrite ( $fp , $log );
        }
    }
    // modifico el valor de las veces
    $_SESSION['veces']=$veces;
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Droppper</title>
            <link rel="icon" href="files_style/Doppper.png" type="image" />
            <link type="text/css" href="files_style/css/mdb.min.css" rel="stylesheet">
            <link type="text/css" href="files_style/css/droppper.css" rel="stylesheet">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
            <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
            <script src="resources/files_style/js/mdb.min.js" language="javascript" type="text/javascript"></script>
    </head>
    <body class="d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="border-h1 container row">
            <header class="col-12">   
                <h1 class="Righteous display-2"><a href="index.php"><img class="upload" src="files_style/upload.png" alt="upload icon"> Droppper </a></h1> 
            </header>

            <?php 
            // muestro los errores según el valor de la variable
            if($error==1){
                echo '<p class="alert alert-warning"> <strong>Aviso:</strong> No has indicado unos datos validos. </p>';
                echo "<hr>";
            }

            if($error==2){
                echo '<p class="alert alert-warning"> <strong>Aviso:</strong> Para acceder a la página primero debes iniciar sesión </p>';
                echo "<hr>";
            }

            // si el error es el 3, fallado muchas veces el formulario
            if($error==3){
                echo '<p class="alert alert-danger"> <strong>Error:</strong> Entrada al sitio bloqueada por fallar '.$veces.' veces</p>';
            }
            // muestro el formulario si no esta bloqueado por fallar más de 5 veces
            else{
            ?>

            <form action="index.php" method="post">
                <!-- Email input -->
                <label class="form-label" for="email">Correo</label>
                <input type="text" id="email" name="email" class="form-control mb-4" />

                <!-- Password input -->
                <label class="form-label " for="pass">Contraseña</label>
                <input type="password" id="pass" name="pass" class="form-control mb-4" />

                <!-- Submit button -->
                <button type="submit" class="btn mb-4 btn-primary btn-block col-12">Sign in</button>
            </form>
        </div>

        <?php }?>
    </body>

</html>




