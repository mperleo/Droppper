<?php 
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: index.php?error');
        die ();
    }

    $archivos = scandir('subidas', 1);

    if(isset($_POST['archivo'])){
        if( file_exists('subidas/'.$_POST['archivo']) ){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-type: ");
            header("Content-disposition: attachment; filename={$_POST['archivo']}");
            header("Content-Transfer-Encoding: binary");
            
            readfile('subidas/'.$_POST['archivo']);
        }
        else{
            $error="El fichero no se pudo crear";
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
                    <a href="principal.php" class="btn  btn-primary margin-buttons-lr margin-buttons-sm">Sube un fichero</a>
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
                <h3>Selecciona un archivo para recuperar:</h3> <br>
                <form method="POST" class="form-check">

                    <input class="btn btn-primary btn-lg" type="submit" value="Descargar"> <br><br>
                    
                    <?php
                        foreach($archivos as $archivo){
                            if(strcmp($archivo,'.')!==0 && strcmp($archivo,'..')!==0){
                                echo '<input type="radio" class="form-check-input" id="archivo" name="archivo" value="'.$archivo.'">';

                                $posPunto=strpos($archivo, '.')+1;
                                $extension=substr( $archivo, -(strlen($archivo) - $posPunto ) );

                                if( file_exists('files_style/file_icons/file_'.$extension.'.svg') ){
                                    echo '<label class="form-check-label" for="archivo"><img src="files_style/file_icons/file_'.$extension.'.svg" alt="'.$extension.'"> '.$archivo.'</label><br><hr>';
                                }
                                else{
                                    echo '<label class="form-check-label" for="archivo"><img src="files_style/file_icons/file_.svg" alt="'.$extension.'"> '.$archivo.'</label><br><hr>';
                                }
                            }
                        }
                    ?>
                    
                    
                </form>
            
            </div>

            <footer class="text-center">
   
                <a href="../myki/index.php">Created by Miguel Pérez León</a>  
 
            </footer>
        </div> 
    </body>

</html>




