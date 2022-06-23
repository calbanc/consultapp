<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdActividadTrabajador"])){
        
	
		$IdActividadTrabajador=$_GET["IdActividadTrabajador"];
		
				
        $consulta="SELECT  CONVERT(varchar(8), ata.HoraInicio,108) as HoraInicio,CONVERT(varchar(8),ata.HoraFinal,108) as Horafinal,ata.UnidadProducida,ata.COD_BUS,tra.ApellidoPaterno,tra.ApellidoMaterno,tra.Nombre,REFRIGERIO,POR_TAREA
        FROM ActividadTrabajadorAndroid ata
        INNER JOIN Trabajador tra ON tra.IdTrabajador=ata.IdTrabajador AND tra.IdEmpresa=ata.IdEmpresaTrabajador
        WHERE ata.IdActividadTrabajador='{$IdActividadTrabajador}' ";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
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