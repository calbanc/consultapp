<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["fechaactividad"])&&isset($_GET["idzona"])&&isset($_GET["IdCuartel"])&&isset($_GET["IdEmpresa"])
    &&isset($_GET["Temporada"])){
        
        $fechaactividad=$_GET["fechaactividad"];
        $idzona=$_GET["idzona"];
		$IdCuartel=$_GET["IdCuartel"];
        $Idcuadrilla=$_GET["Idcuadrilla"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];

		date_default_timezone_set('America/Bogota');
		$fecha_firma=date('d/m/Y H:i:s',time());
	


		$sqlwhere="";

		if($Idcuadrilla!='TODOS'){
			$sqlwhere.=" AND IdCuadrilla='{$Idcuadrilla}'";
        }
        if($IdEmpresa=='9' && $idzona=='55'){
            $sqlwhere.="  AND  IdCuartel='{$IdCuartel}'";
        }

		
		$consulta="UPDATE ActividadTrabajadorAndroid SET SW_VALIDADO='1' , fecha_firma='{$fecha_firma}' , usuario_firma='{$usuario}'
         WHERE  CONVERT(VARCHAR,FechaActividad,23)='{$fechaactividad}' 
         AND IdEmpresa='{$IdEmpresa}' AND Temporada='{$Temporada}'  AND IdZona='{$idzona}'  " .$sqlwhere."";
	

		$resultado=sqlsrv_query($conexion,$consulta);
        
		if($resultado){
			$data=array(
				'id'=>'REGISTRA'
			); 
			$json[]=$data;
			echo json_encode($json);
	
					   
		}else{
				   $data=array(
					   'id'=>'NO REGISTRA'
				   );
				   $json[]=$data;
				   echo json_encode($json);
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