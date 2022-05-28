<?PHP

$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])&&isset($_GET["Fecha"])&&isset($_GET["IdTrabajador"])){
        
	
		$IdEmpresa=$_GET["IdEmpresa"];
        $Fecha=$_GET["Fecha"];
        $IdTrabajador=$_GET["IdTrabajador"];
		
		
		$consulta="SELECT COUNT(Idempresa) AS 'Marcacion',COUNT(HORAINICIO) as 'HORAINICIO',
        CONVERT(VARCHAR,HORAINICIO,8)AS 'horaentrada',COUNT(HORAFINAL) as 'HORAFINAL',CONVERT(VARCHAR,HORAFINAL,8) AS 'horasalida' ,isnull(EstacionInicio,'MARCACION MANUAL') as EstacionInicio,isnull(EstacionFinal,'MARCACION MANUAL') AS 'EstacionFinal'
        FROM LecturasSmart 
        WHERE IdEmpresa='{$IdEmpresa}' and Fecha='{$Fecha}' and IdTrabajador='{$IdTrabajador}' GROUP BY IDEMPRESA,HORAINICIO,HORAFINAL,ESTACIONINICIO,ESTACIONFINAL ";
		
		
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
