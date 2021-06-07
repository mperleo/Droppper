<?php 
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: index.php?error');
        die ();
    }

    $archivos = scandir('subidas', 1);

    if(isset($_GET['archivo'])){
        if( file_exists('subidas/'.$_GET['archivo']) ){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-type: ".mime_content_type($_GET['archivo']));
            header("Content-disposition: attachment; filename={$_GET['archivo']}");
            header("Content-Transfer-Encoding: binary");
            
            readfile('subidas/'.$_GET['archivo']);
        }
        else{
            $error="El fichero no se pudo descargar";
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
    <body class="d-flex justify-content-center align-items-center" style="margin-top: 10px">
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
                <h3>Selecciona un archivo para descargar:</h3> <br>
                <div class="row g-4 back-downloads" style="overflow: auto; height:500px; margin: 10px">
                    <?php
                        foreach($archivos as $archivo){
                            if(strcmp($archivo,'.')!==0 && strcmp($archivo,'..')!==0){

                                $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                                
                                if(strcmp($extension, 'png')===0 || strcmp($extension, 'jpeg')===0 || strcmp($extension, 'jpg')===0 || strcmp($extension, 'svg')===0 || strcmp($extension, 'gif')===0){
                                    $imagen= 'subidas/'.$archivo;
                                }
                                else if( file_exists('files_style/file_icons/file_'.$extension.'.svg') ){
                                    $imagen='files_style/file_icons/file_'.$extension.'.svg';
                                }
                                else{
                                    $imagen='files_style/file_icons/file_.svg';   
                                }
                    ?>
                    <div class="col-md-4">     
                        <div class="card" style="width: 13rem; height:25rem;">
                            <img src="<?php echo $imagen?>" class="card-img-top" alt="<?php echo $imagen?>"/>
                            <div class="card-body">
                                <p class="card-text"><?php echo $archivo?></p>
                                
                            </div>
                            <div class="card-footer text-center">
                                <a href="archivos.php?archivo=<?php echo $archivo?>" class="btn btn-primary">Descargar</a>
                            </div>
                        </div>
                    </div>
                    <?php            
                            }
                        }
                    ?>
                </div>
            </div>

            <footer class="text-center">
   
                <a href="../myki/index.php">Created by Miguel Pérez León</a>  
 
            </footer>
        </div> 
    </body>

</html>




