<?php
class Conexion {

    private $host = "localhost";
    private $dbname = "inventario_telefonos";
    private $username = "root";
    private $password = "";                   //"PDsxUBocsNe[Qh-8";
    public $conexion;

    public function conectar() {

        $this->conexion = null;

        try {

            $this->conexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->username,
                $this->password
            );

            // Configurar PDO para que lance excepciones
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {

            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conexion;
    }
}
?>