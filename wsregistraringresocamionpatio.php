<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["id"])){
        
      
        $Id=$_GET["id"];
        

        date_default_timezone_set('America/Santiago');
		$Fecha_salida=date('d/m/Y H:i:s',time());

		
        
        $consulta="UPDATE ANDROID_RECEPCION_CAMIONES SET Fecha_ingreso='{$Fecha_salida}' WHERE Id='{$Id}'" ;
        
        $resultado=sqlsrv_query($conexion,$consulta);

	
		if($resultado){  
            
               
                $resultar["registro"]='ACTUALIZADO';
               
                $json[]=$resultar;   
                    
                

            
            
            

        }
		
		echo json_encode($json);
	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 
	
?>