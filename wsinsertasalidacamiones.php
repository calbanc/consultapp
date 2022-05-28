<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["Id"])
    &&isset($_GET["Fecha_ingreso"])
    &&isset($_GET["Fecha_salida"]) 
    &&isset($_GET["Patente"])
    ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $Id=$_GET["Id"];
        $Fecha_ingreso=$_GET["Fecha_ingreso"];
        $Fecha_salida=$_GET["Fecha_salida"];
        
        $Patente=$_GET["Patente"];
      

		$consulta="UPDATE ANDROID_RECEPCION_CAMIONES SET Fecha_salida='{$Fecha_salida}', UsuarioSis_salida='{$usuario}'  where Id='{$Id}' AND CONVERT(date,Fecha_ingreso,103)='{$Fecha_ingreso}'  AND Patente='{$Patente}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'" ;

		$resultado=sqlsrv_query($conexion,$consulta);
		if($resultado){
            $consultainsertado="SELECT * FROM ANDROID_RECEPCION_CAMIONES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'  AND CONVERT(date,Fecha_ingreso,103)='{$Fecha_ingreso}'  AND Patente='{$Patente}'  AND Fecha_salida='{$Fecha_salida}' AND UsuarioSis_salida='{$usuario}' ";
            $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
            while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                $json[]=$registro;
            }        
            echo json_encode($json);              
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