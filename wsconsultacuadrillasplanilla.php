<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        
		
		$consulta="SELECT act.idcuadrilla,tr.nombre,tr.apellidopaterno,tr.apellidomaterno
		from ActividadTrabajadorAndroid act
		inner join cuadrilla cu on cu.idcuadrilla=act.IdCuadrilla and cu.Idempresa=act.idempresa
		inner join Trabajador tr on cu.IdTrabajador_Enc=tr.idtrabajador and cu.idempresa=tr.idempresa
        where act.idzona='{$idzona}' and Convert(date,act.fechaactividad)='{$fechaactividad}' and act.SW_VALIDADO is null 
        group by act.idcuadrilla,tr.nombre,tr.apellidopaterno,tr.apellidomaterno";
		
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
	
?>