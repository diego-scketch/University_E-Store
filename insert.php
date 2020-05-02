<?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

if(!empty($nombre) || !empty($email) || 
!empty($telefono) || !empty($usuario)|| !empty($clave)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "12345";
    $dbname = "proyectointegrador";

    //creando conexión
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Error de conexión: ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else {
        $SELECT = "SELECT email from registrarusuario WHERE email = ?
         Limit 1";
        $INSERT = "INSERT into registrarusuario
         (nombre, email, telefono, usuario, clave)
        values (?, ?, ?, ?, ?)";

        //preparar sentencia
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssiss", $nombre, $email, $telefono, $usuario, $clave);
            $stmt->execute();
            echo "Sus datos de registro han sido almacenados";
            header('Location: http://localhost/MyProjects/parcial2/University_E-Store/registro_completado.html');
            
        }
        else {
            echo "El e-mail registrado ya existe";
        }
        $stmt->close();
        $conn->close();

    }
}
else {
    echo "Todos los campos son requeridos";
    die();
}
?>