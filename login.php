<?php

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

if(!empty($usuario) || !empty($clave)) {
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
        $SELECT = "SELECT usuario from login_usuario WHERE usuario = ?
         Limit 1";
        $INSERT = "INSERT into login_usuario
         (usuario, clave)
        values (?, ?)";

        //preparar sentencia
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($usuario);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ss", $usuario, $clave);
            $stmt->execute();
            echo "Sus datos de registro han sido almacenados";
            header('Location: http://localhost/MyProjects/parcial2/University_E-Store/no_registrado.html');
            
        }
        else {
            echo "Bienvenido!";
            header('Location: http://localhost/MyProjects/parcial2/University_E-Store/bienvenido.html');
        }
        $stmt->close();
        $conn->close();

    }
}
else {
    echo "Chao papá. Tu código no se ejecutó.";
    

    die();
}
?>