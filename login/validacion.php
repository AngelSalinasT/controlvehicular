<?php
include("../controlador/controlador.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    
    if (isset($_FILES['keyfile']) && $_FILES['keyfile']['error'] == 0) {
        $file_tmp_path = $_FILES['keyfile']['tmp_name'];
        
        $password = file_get_contents($file_tmp_path);
        
        $Con = Conectar();
        $SQL = "SELECT * FROM cuentas WHERE userName='$usuario'";
        $ResultSet = Ejecutar($Con, $SQL);
        $contador = 0;
        
        if (mysqli_num_rows($ResultSet) > 0) {
            echo "El $usuario existe";
            $Fila = mysqli_fetch_row($ResultSet);
            if(trim($password) == $Fila[1]){
                print("\nContraseña correcta");
                $intentos = 0;
                $SQL_update = "UPDATE cuentas SET intentos=$intentos WHERE userName='$usuario'";
                Ejecutar($Con, $SQL_update);
                $contador++;
                if($Fila[3] == 1){
                    print("\nCuenta Activa");
                    if($Fila[4] == 0){
                        print("\nCuenta No Bloqueada");
                        print("\nEntrar");
                        if($Fila[2] == "U"){
                            header("Location: ../navbar/MenuUsuario.html");
                        } else{
                            header("Location: ../navbar/MenuAdmin.html");
                        }
                    } else{
                        print("\nCuenta BLOQUEADA");
                    }
                } else{
                    print("\nCuenta NO Activa");
                }
                
            } else{
                print("\nContraseña incorrecta");
                $intentos = $Fila[5] + 1;
                print("Numero de intentos: $intentos");
                $SQL_update = "UPDATE cuentas SET intentos=$intentos WHERE userName='$usuario'";
                Ejecutar($Con, $SQL_update);

                if($intentos >= 4){
                    $SQL_bloquear = "UPDATE cuentas SET bloqueo=1 WHERE userName='$usuario'";
                    Ejecutar($Con, $SQL_bloquear);
                    echo "La cuenta ha sido bloqueada debido a múltiples intentos fallidos.";
                }
            }
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
        
        Desconectar($Con);
    } else {
        echo "Error al subir el archivo de clave.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
