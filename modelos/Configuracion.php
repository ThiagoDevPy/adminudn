<?php
//incluir la conexion de base de datos

require "../config/conexion.php";

class Configuracion
{




    public function __construct()
    {
        
    }


    
    public function editar($valor)
    {   
       
        $sql = "UPDATE configuracion SET valor = ? WHERE clave = 'base_url'"; 
        return ejecutarConsulta($sql);
    }
    
    	
    //metodo mostrar registros
    public function mostrar()
    {
        $sql = "SELECT * FROM configuracion";
        return ejecutarConsultaSimplefila($sql);
    }

}

?>