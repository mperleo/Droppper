<?php 
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: index.php?error');
        die ();
    }

    if(isset($_FILES['archivo'])){
        if ($_FILES['archivo']["error"] > 0){
            $mensaje= "<div class='alert alert-danger' role='alert'><b>Codigo de error: </b> " . $_FILES['archivo']['error'] . "<hr>";

            if($_FILES['archivo']["error"] == UPLOAD_ERR_EXTENSION) $mensaje =$mensaje."Error de una extensión.";
            else if($_FILES['archivo']["error"] == UPLOAD_ERR_INI_SIZE) $mensaje =$mensaje."El archivo se pasa del tamaño maximo de subida.";
            else if($_FILES['archivo']["error"] == UPLOAD_ERR_FORM_SIZE) $mensaje =$mensaje."El archivo se pasa del tamaño permitido.";
            else if($_FILES['archivo']["error"] == UPLOAD_ERR_PARTIAL) $mensaje =$mensaje."El fichero no se subio completo.";
            else if($_FILES['archivo']["error"] == UPLOAD_ERR_NO_FILE) $mensaje =$mensaje."No se ha indicado ningún fichero.";
            else if($_FILES['archivo']["error"] == UPLOAD_ERR_NO_TMP_DIR) $mensaje =$mensaje."El directorio temporal no se encuentra.";
            else if($_FILES['archivo']["error"] == UPLOAD_ERR_CANT_WRITE) $mensaje =$mensaje."No se puede escribir el fichero en disco.";
            
            $mensaje =$mensaje."</div>";
        }
        else{
            if(!empty($_POST['nombre'])){
                $posPunto=strpos($_FILES['archivo']['name'], '.');
                $extension=substr( $_FILES['archivo']['name'], -(strlen($_FILES['archivo']['name']) - $posPunto ) );

                move_uploaded_file($_FILES['archivo']['tmp_name'], "subidas/".$_POST['nombre'].$extension);

                $nombre = $_POST['nombre'].$extension;
            }
            else{
                move_uploaded_file($_FILES['archivo']['tmp_name'], "subidas/" . $_FILES['archivo']['name']);
                $nombre= $_FILES['archivo']['name'];
            }

            $mensaje= '<div class="alert alert-primary" role="alert"><b>Archivo subido con exito</b>.<hr> <b>Detalles del archivo:</b><br> ';
            $mensaje= $mensaje."<u>Nombre</u>: " . $nombre . "<br>";
            $mensaje= $mensaje."<u>Tipo</u>: " . $_FILES['archivo']['type'] . "<br>";
            $mensaje= $mensaje."<u>Tamaño:</u> " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
            $mensaje =$mensaje."</div>";
            
        }
    }
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
        <div class="row border-h1 container">
            <header>
                <div class=" text-center">
                    <h1 class="Righteous display-2"><a href="principal.php">Droppper</a></h1> 
                    <a href="index.php?logout" class="btn  btn-primary margin-buttons-lr margin-buttons-sm">Cerrar sesion</a>
                    <a href="archivos.php" class="btn  btn-primary margin-buttons-lr margin-buttons-sm">Archivos</a>
                </div>
            </header>

            <?php 
                if(isset($mensaje)){
                    echo '<div>';
                        echo $mensaje;
                    echo '</div>';
                }
            ?>

            <div>
                <form action="principal.php" method="post" enctype="multipart/form-data">

                    <label for="nombre" class="form-label">Indica un nombre para el archivo (opcional).</label>
                    <input type="text" class="form-control form-control-lg margin-buttons-sm" name="nombre" id="nombre"/>

                    <label for="archivo" class="form-label">Selecciona un archivo para subir:</label>
                    <input type="file" class="form-control form-control-lg margin-buttons-sm" name="archivo" id="archivo"/>

                    <input type="submit" value="Subir archivo" class="btn btn-lg btn-primary btn-block margin-buttons-sm"/>
                </form>
            </div>

            <footer class="text-center">
   
                <a href="../myki/index.php">Created by Miguel Pérez León</a>  
 
            </footer>
        </div> 
    </body>

</html>




