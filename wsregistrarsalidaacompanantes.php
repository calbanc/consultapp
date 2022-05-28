<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["Id"])){
        
      
        $Id=$_GET["Id"];
        $GuiaSalida=$_GET["GUIASALIDA"];
       

        date_default_timezone_set('America/Santiago');
		$Fecha_salida=date('d/m/Y H:i:s',time());

		
      
            $consultafecha="SELECT CONVERT(VARCHAR,Fecha_ingreso,23) AS 'Fecha_ingreso',Patente FROM ANDROID_RECEPCION_CAMIONES WHERE Id='{$Id}'";
            
            $resultadoconsu=sqlsrv_query($conexion,$consultafecha);

            if($registrofecha=sqlsrv_fetch_array($resultadoconsu)){
               
                $fechaingreso=$registrofecha['Fecha_ingreso'];
                $patente=$registrofecha['Patente'];

                $actualizaacompañantes="UPDATE ANDROID_RECEPCION_CAMIONES SET Fecha_salida='{$Fecha_salida}',Guia_salida='{$GuiaSalida}', UsuarioSis_salida='{$usuario}' where CONVERT(DATE,Fecha_ingreso)='{$fechaingreso}' and Patente='{$patente}' and Id<>'{$Id}' and Fecha_salida IS NULL";

                $resultadoacompañantes=sqlsrv_query($conexion,$actualizaacompañantes);
                if($resultadosacompañantes=sqlsrv_fetch_array($resultadoacompañantes)){
                        $resultar["registro"]='ACTUALIZADO';
                        $json[]=$resultar;           
                }else{
                    
                }           
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