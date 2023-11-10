<?php
session_start();
error_reporting(E_ALL);

/* Conecta a la base de datos */
require_once("../nucleo/constantes.php");
require_once("../nucleo/conexion.php");


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Se escapan los caracteres que sea necesario escapar en el nombre de usuario.
        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $clave = $mysqli->real_escape_string($_POST['clave']);

        if (($nombre != "") && ($clave != "")) {
  
            $query = "SELECT * FROM trabajadores WHERE usuario = '$nombre' AND clave = '$clave' AND isDeleted='0' AND tipo=1";

            //echo $query;
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            $count = mysqli_num_rows($result);

            if ($count == 1) {

                $id = $row['id'];
                $tipo = $row['tipo'];
                $nombre = $row['nombre'];
                //   $descripcion = $row['user_nombre'];
                //   $foto = $row['foto'];

                if ($foto == "") {
                    $foto = "./img/base32.png";
                } else {
                    // $foto = "../perfiles/" . $foto;
                }


                // Se inicia la sesión y se registra la variable con el nombre de usuario.
                $_SESSION['descripcion'] = $nombre;
                $_SESSION['id'] = $id;
                $_SESSION['tipo'] = $tipo;
                //   $_SESSION['foto'] = $foto;
                $_SESSION['logo'] = './img/logo_menu.png'; //'./img/avatar2.png'
                $result->free();

                //LOGS ACCESO
                $ipacceso = $_SERVER['REMOTE_ADDR'];
                $user_acceso = $nombre;
                $pass_acceso = $clave;
                $panel_acceso = "TRABAJADOR";
                $estado_acceso = "OK";

                $query = "INSERT INTO logs_acceso(ip, usuario, clave, fecha, panel, estado) 
                        VALUES (?,?,?,NOW(),?,?)";

                /* Prepare statement */
                $stmt     = $mysqli->prepare($query);
                if (!$stmt) {
                    echo 'Error: ' . $mysqli->error;
                }

                /* Bind parameters */
                $stmt->bind_param('sssss', $ipacceso, $user_acceso, $pass_acceso, $panel_acceso, $estado_acceso);
                /* Execute statement */
                if (!$stmt->execute()) echo $stmt->error;
                $stmt->close();

                //FIN LOGS ACCESO
                header("Location: ./listado_ots");
            } else {
                //LOGS ACCESO
                $ipacceso = $_SERVER['REMOTE_ADDR'];
                $user_acceso = $nombre;
                $pass_acceso = $clave;
                $panel_acceso = "ADMIN";
                $estado_acceso = "FALLIDO";

                $query = "INSERT INTO logs_acceso(ip, usuario, clave, fecha, panel, estado) 
                        VALUES (?,?,?,NOW(),?,?)";

                /* Prepare statement */
                $stmt = $mysqli->prepare($query);
                if (!$stmt) {
                    echo 'Error: ' . $mysqli->error;
                }

                /* Bind parameters */
                $stmt->bind_param('sssss', $ipacceso, $user_acceso, $pass_acceso, $panel_acceso, $estado_acceso);
                /* Execute statement */
                if (!$stmt->execute()) echo $stmt->error;
                $stmt->close();

                //FIN LOGS ACCESO

                //return the error message
                echo "<div class=\"alert alert-warning\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Warning!</strong> Usuario o Contraseña no válido.
                    </div>";
            }
        } else {
            //return the error message
            echo "<div class=\"alert alert-warning\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Warning!</strong> Usuario o Contraseña no válido.
                </div>";
        }

        /* close connection */
        $mysqli->close();
    }

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="es" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Blamel</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/favicons/favicon.ico">
    <link rel="manifest" href="./assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="./assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="./assets/js/config.js"></script>
    <script src="./vendors/simplebar/simplebar.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="./vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="./assets/css/theme-rtl.css" rel="stylesheet" id="style-rtl">
    <link href="./assets/css/theme.css" rel="stylesheet" id="style-default">
    <link href="./assets/css/user-rtl.css" rel="stylesheet" id="user-style-rtl">
    <link href="./assets/css/user.css" rel="stylesheet" id="user-style-default">
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid">
        <!-- <script>
          var isFluid = JSON.parse(localStorage?.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container?.classList.remove('container');
            container?.classList.add('container-fluid');
          }
        </script> -->
        <div class="row min-vh-100 bg-100">
          <div class="col-6 d-none d-lg-block position-relative">
            <div class="bg-holder" style="background-image:url(./img/login_background.png);background-position: 50% 20%;">
            </div>
            <!--/.bg-holder-->

          </div>
          <div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
            <div class="row justify-content-center g-0">
              <div class="col-lg-9 col-xl-8 col-xxl-6">
                <div class="card">
                  <div class="card-header bg-shape text-center p-2"><div class="font-sans-serif fw-bolder fs-4 z-1 position-relative link-light" href="./index.html" data-bs-theme="light">BLAMEL</div></div>
                  <div class="card-body p-4">
                    <div class="row flex-between-center">
                      <div class="col-auto">
                        <h3>Login</h3>
                      </div>
                      <!-- <div class="col-auto fs--1 text-600"><span class="mb-0 fw-semi-bold">New User?</span> <span><a href="./pages/authentication/split/register.html">Create account</a></span></div> -->
                    </div>

                    <form method="POST" name="acceso" id="acceso" novalidate="novalidate">
                      <div class="mb-3">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input class="form-control" id="nombre" type="text" name="nombre" placeholder="Usuario" id="nombre" required autofocus/>
                      </div>
                      <div class="mb-3">
                        <div class="d-flex justify-content-between">
                          <label class="form-label" for="password">Clave</label>
                        </div>
                        <input class="form-control" type="password" name="clave" id="password" placeholder="Contraseña" required="" />
                      </div>
                      <div class="row flex-between-center">
                        <div class="col-auto">
                          <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="split-checkbox" />
                            <label class="form-check-label mb-0" for="split-checkbox">Recordar</label>
                          </div>
                        </div>
                        <!-- <div class="col-auto"><a class="fs--1" href="./pages/authentication/split/forgot-password.html">Forgot Password?</a></div> -->
                      </div>
                      <div class="mb-3">
                      <!-- onclick="beforeSubmit()" -->
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit" onclick="beforeSubmit()" >Log in</button>
                      </div>
                    </form>
                    <!-- <div class="position-relative mt-4">
                      <hr />
                      <div class="divider-content-center">or log in with</div>
                    </div>
                    <div class="row g-2 mt-2">
                      <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                      <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
  <script type="text/javascript">
    const remember_local_key = btoa('blamel_credentials');
    const nombre = document.querySelector('#nombre');
    const password = document.querySelector('#password');
    const splitCheckbox = document.querySelector('#split-checkbox');
    let credentials = {
      nombre: null,
      password: null
    };

    (function getStorageCredentials() {
      try {
        const storageData = localStorage.getItem(remember_local_key) ?? {};
        credentials = JSON.parse(atob(storageData))
      }catch(error) {
        // ERROR 
      }
      const { nombre: credentialName, password: credentialPassword } = credentials ?? {};
      nombre.value = credentialName ?? '';
      password.value = credentialPassword ?? '';
      if(credentialName && credentialPassword) splitCheckbox.checked = true;
    })();

    function beforeSubmit() {
      if(!splitCheckbox.checked){
        localStorage.removeItem(remember_local_key);
        return
      }
      credentials = {nombre: nombre.value, password: password.value};
      try {
        localStorage.setItem(remember_local_key, btoa(JSON.stringify(credentials)))
        console.log('guardadppppp')
      }catch(error){
        // ERROR 
      }
    }
  </script>
</html>
