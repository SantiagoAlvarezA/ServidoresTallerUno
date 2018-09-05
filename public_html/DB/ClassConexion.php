<?php

class Conexion
{
    private $user;
    private $password;
    private $host;
    private $conexion;
    private $DB;

    public function getConexion()
    {
        $this->user = 'postgres';
        $this->password = 's';
        $this->host = 'localhost';
        $this->DB = 'UserSantiago';

        try
        {
            $this->conexion = new PDO("pgsql:host=$this->host;port=5432;dbname=$this->DB",$this->user,$this->password);
            $this->conexion->exec("SET CHARACTER SET UTF8");
            return $this->conexion;
        }catch (Exception $exc)
        {
            echo $exc->getTraceAsString();
        }

    }
    
}
