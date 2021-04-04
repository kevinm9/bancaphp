<?php
    include_once'db/connect_db.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }
    include_once'inc/header_all.php';

    function enviarcorreo($correo,$usuario,$clave) {
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'bankokoec@gmail.com';                     //SMTP username
        $mail->Password   = 'Prueba12345';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for 
        $mail->setFrom('bankokoec@gmail.com', 'Banca electrónica');
        $mail->addAddress($correo);//Add a recipient
        $mail->Subject = 'BANCA DEL ECUADOR';
        $mail->Body .="<h1 style='color:#3498db;'>Banca electrónica!</h1>";
        $mail->Body .= "<p>Mensaje automatico<br></p>";
        $mail->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p><br>";
        $mail->Body .= "<p>usuario: ".$usuario."</p><br>";
        $mail->Body .= "<p>clave: ".$clave."</p>";
        $mail->IsHTML(true);
        $mail->Send();
        } catch (Exception $e) {
                                echo'<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Warning", "NO SE ENVIO CORREO ", "warning", {
                        button: "Continue",
                            });
                        });
                        </script>';
            }
    }


    function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }

    function limpia_espacios($cadena){
      $cadena = str_replace(' ', '', $cadena);
      return $cadena;
    }



    function generaPass(){
        //Se define una cadena de caractares.
        //Os recomiendo desordenar las minúsculas, mayúsculas y números para mejorar la probabilidad.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);
     
        //Definimos la variable que va a contener la contraseña
        $pass = "";
        //Se define la longitud de la contraseña, puedes poner la longitud que necesites
        //Se debe tener en cuenta que cuanto más larga sea más segura será.
        $longitudPass=8;
     
        //Creamos la contraseña recorriendo la cadena tantas veces como hayamos indicado
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
     
            //Vamos formando la contraseña con cada carácter aleatorio.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    function generadordenombre($pri_nombre,$pri_apellido){

        $pri_nombre= limpia_espacios($pri_nombre);
        $pri_apellido= limpia_espacios($pri_apellido);

        $pri_nombre= quitar_tildes($pri_nombre);
        $pri_apellido= quitar_tildes($pri_apellido);

        $pri_nombre = strtoupper($pri_nombre);
        $pri_apellido =strtoupper($pri_apellido);

        $incial = $pri_nombre[0];
        $gusername = $incial . $pri_apellido;


        return $gusername;
    }

    

    if(isset($_POST['submit'])){


        $identificacion = $_POST['identificacion'];
        $nombre = strtoupper($_POST['nombre']);
        $apellido = strtoupper($_POST['apellido']);
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $tipodecuenta = $_POST['tipodecuenta'];
        //generados
        $fecha = date('Y-m-d');
        $username = generadordenombre($nombre,$apellido);
        $password = generaPass();
        $role = 'Operator';



      
        if(isset($_POST['identificacion'])){


        try {

                $select = $pdo->prepare("SELECT identificacion FROM tbl_user WHERE identificacion='$identificacion'");
                $select->execute();

                if($select->rowCount() > 0 ){
                    echo'<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Warning", "El usuario con esa cedula ya existe ", "warning", {
                        button: "Continue",
                            });
                        });
                        </script>';
                } else {

                    $resultcont = $pdo->query("SELECT COUNT(*) total FROM tbl_user"); //obtener el total de cuentas registradas
                    $totalcont = $resultcont->fetchColumn();
                    $totalcont++;
                    $numerodecuentasinletra = substr(str_repeat(0,5).$totalcont, - 5); //5 dijitos 00001

                    if($tipodecuenta=="Ahorro" ){
                        $numerodecuenta = 'CA'.$numerodecuentasinletra;//CA dijitos CA00001
                    } else {
                        $numerodecuenta = 'CC'.$numerodecuentasinletra;
                    }

                    //insert query here
                    $insert = $pdo->prepare("INSERT INTO tbl_user(identificacion,nombre,apellido,direccion,correo,tipodecuenta,numerodecuenta,fecha,username,password,role,is_active) VALUES(:identificacion,:nombre,:apellido,:direccion,:correo,:tipodecuenta,:numerodecuenta,:fecha,:username,:password,:role,1)");

                    $insert->bindParam(':identificacion',$identificacion);
                    $insert->bindParam(':nombre',$nombre);
                    $insert->bindParam(':apellido',$apellido);
                    $insert->bindParam(':direccion',$direccion);
                    $insert->bindParam(':correo',$correo);
                    $insert->bindParam(':tipodecuenta',$tipodecuenta);
                    $insert->bindParam(':numerodecuenta',$numerodecuenta);
                    $insert->bindParam(':fecha',$fecha);
                    $insert->bindParam(':username',$username);
                    $insert->bindParam(':password',$password);
                    $insert->bindParam(':role',$role);
                    if($insert->execute()){
                        
                        echo'<script type="text/javascript">
                            jQuery(function validation(){
                            swal("Registro Exitoso", "Usuario ingresado satisfactoriamente,revise su correo", "success", {
                            button: "Continue",
                                });
                            });
                            </script>';
                        enviarcorreo($correo,$username,$password);
                        echo "
                        <script>
                        window.open('http://localhost/pos-master/misc/reportecuenta.php?ci=".$identificacion."', '_blank');
                        </script>";


                    }else{

                        echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Error no se guardaron los datos", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';


                    }

                }

        } catch (Exception $e) {

             echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "ocurrio un error", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';

            

        }
        



        }

    }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <form action="" method="POST">
            <!-- Registration Form -->
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Creación de cuentas bancarias</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                        <div class="box-body">
                                <div class="form-group">
                                    <label for="fusername">Identificacion</label>
                                    <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="Ingrese el identificacion" required>
                                </div>
                                <div class="form-group">
                                    <label for="fNombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su Nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="fApellido">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su Apellido" required>
                                </div>
                                <div class="form-group">
                                    <label for="fDireccion">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese su direccion" required>
                                </div>
                                <div class="form-group">
                                    <label for="fCorreo">Correo electrónico </label>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese un correo" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de cuenta </label>
                                    <select class="form-control" name="tipodecuenta" required>
                                        <option>Ahorro</option>
                                        <option>Corriente</option>
                                    </select>
                                </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>

        </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>

  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>