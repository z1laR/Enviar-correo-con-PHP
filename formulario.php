<?php
$error = '';
$empresa = '';
$nombre = '';
$email = '';
$telefono = '';
$mensaje = '';
$captcha = '';

//CONFIGURAR PARÁMETROS, LEER, EVALUAR Y ENVIAR reCaptcha V2
function post_captcha($user_response) {
    $fields_string = '';
    $fields = array(
        'secret' => '6LcD_KgUAAAAAKh2RdVgoPdSGGj9gY_gbuT0B7mT',
        'response' => $user_response
    );
    foreach($fields as $key=>$value)
    $fields_string .= $key . '=' . $value . '&';
    $fields_string = rtrim($fields_string, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

//VALIDAR reCaptcha V2
if(empty($_POST['g-recaptcha-response']))
{
    $error .= 'Completa el reCaptcha <br>';
}
else
{
    $captcha = $_POST["g-recaptcha-response"];
}

//VALIDAR NOMBRE DE EMPRESA
if(empty($_POST["empresa"]))
{
    $error .= 'Ingresa el nombre de su empresa <br>';
}
else
{
    $empresa = $_POST["empresa"];
    $empresa = filter_var($empresa, FILTER_SANITIZE_STRING);
    $empresa = trim($empresa);

    if($empresa == '')
    {
        $error = 'Empresa no puede estár vacío </br>';
    }
}

//VALIDAR NOMBRE DE PERSONA
if(empty($_POST["nombre"]))
{
    $error .= 'Ingresa el nombre de persona de contacto <br>';
}
else
{
    $nombre = $_POST["nombre"];
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $nombre = trim($nombre);

    if($nombre == '')
    {
        $error = 'Nombre no puede estár vacío </br>';
    }
}

//VALIDAR ESTRUCTURA DE EMAIL
if(empty($_POST["email"]))
{
    $error .= 'Ingresa un email <br>';
}
else
{
    $email = $_POST["email"];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error .= 'Email inválido, verifica su estructura';
    }
    else
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}

//VALIDAR TELEFONO
if(empty($_POST["telefono"]))
{
    $error .= 'Ingresa un télefono de contacto <br>';
}
else
{
    $telefono = $_POST["telefono"];
    $telefono = filter_var($telefono, FILTER_SANITIZE_STRING);
    $telefono = trim($telefono);

    if($telefono == '')
    {
        $error = 'Teléfono no puede estár vacío </br>';
    }
}

//VALIDAR MENSAJE
if(empty($_POST["mensaje"]))
{
    $error .= 'Ingresa un mensaje breve <br>';
}
else
{
    $mensaje = $_POST["mensaje"];
    $mensaje = filter_var($mensaje, FILTER_SANITIZE_STRING);
    $mensaje = trim($mensaje);

    if($mensaje == '')
    {
        $error = 'Mensaje no puede estár vacío </br>';
    }
}

//ESTRUCTURANDO EMAIL
$cuerpo = '
            <!doctype html>
            <html lang="en">
            <head>
                <!-- Required meta tags -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
            </head>
            <body>

            <div class="container">
            <div class="row justify-content-center mt-4 pt-4">
                <p class="col-12" align="center">
                <a href="http://www.envirosolutions.com"><IMG SRC="https://www.lstindustries.com/wp-content/uploads/2016/02/logo_envirosolutions.png" alt="Enviro Solutions" width="90" height="90"></p></a>
            </div>
            <div class="row">
                <h1 class="text-center col-12">Enviro Solutions</h1>
                <br>
            </div>
            <div class="row">
                <h2 class="text-primary text-left col-12 ">Contact</h2>
                <br>
            </div>
            <div class="row mt-3">
                <p class="text-uppercase col-12 col-sm-12 col-md-3"><b>Company: </b></p>
                <p class="col-12 col-sm-12 col-md-3">'.$empresa.'</p>
                <p class="text-uppercase col-12 col-sm-12 col-md-3"><b>Contact person: </b></p>
                <p class="col-12 col-sm-12 col-md-3">'.$nombre.'</p>
            </div>
            <div class="row">
                <p class="text-uppercase col-12 col-sm-12 col-md-3"><b>Email: </b></p>
                <p class="col-12 col-sm-12 col-md-3">'.$email.'</p>
                <p class="text-uppercase col-12 col-sm-12 col-md-3"><b>Telephone: </b></p>
                <p class="col-12 col-sm-12 col-md-3">'.$telefono.'</p>        
            </div>
            <div class="row">
                <p class="text-uppercase col-12 col-sm-12 col-md-12 text-center"><b>Message: </b></p>
                <p class="col-12 col-sm-12 col-md-12 text-justificy">'.$mensaje.'</p>
            </div>
            </div>

            <!-- Optional JavaScript -->
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

                <footer class="text-white bg-primary text-center">&#9400; <a class="text-white" href="http://www.envirosolutions.com">Enviro Solutions</a> 2017 - 2018 | All rights reserved</footer>

            </body>
            </html>
            ';

//TIPO DE CODIFICACIÓN
$enviarA  = 'MIME-Version: 1.0' . "\r\n";
//$enviarA .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$enviarA .= 'Content-type: text/html; charset=utf-8' . "\r\n";

//DIRECCIÓN DE EMISOR
$enviarA = "To: Sales <sales@envirosolutions.com>" . "\r\n";
$enviarA .= "To: Omar MP <z.1laR@hotmail.com>" . "\r\n";
$enviarA .= "From: Enviro Solutions <sales@envirosolutions.com>" . "\r\n";

//ASUNTO
$asunto = 'Nuevo mensaje para Enviro Solutions';

//ENVIAR CORREO
if($error == '')
{
    /*$success = mail($email, $asunto, $cuerpo, $enviarA);
    echo 'exito';*/

    mail($email, $asunto, $cuerpo, $enviarA);
    echo 'exito';

}
else
{
    echo $error;
}
?>