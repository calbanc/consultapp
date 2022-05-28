<?PHP

$hostname_localhost="192.168.2.210";

session_start();


if(isset($_SESSION["usuario"])&&isset($_SESSION["clave"])){

	$usuario=$_SESSION["usuario"];
	$clave=$_SESSION["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdActividadTrabajador"])&&isset($_GET["rendimiento"])){
        
        $IdActividadTrabajador=$_GET["IdActividadTrabajador"];
        $rendimiento=$_GET["rendimiento"];
        
	
		//$consulta="UPDATE ActividadTrabajadorAndroid SET UnidadProducida='{$rendimiento}'  WHERE IdActividadTrabajador='{$IdActividadTrabajador}' ";
		$consulta="UPDATE ActividadTrabajadorAndroid SET UnidadProducida=? WHERE IdActividadTrabajador=?";
		$parametros = array($rendimiento, $IdActividadTrabajador);
		
		$resultado=sqlsrv_query($conexion,$consulta,$parametros);
        
		if($resultado){
			echo 'registra';
		}
		

   }else{
	   $resultar["id"]='Ws no Retorna';
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
