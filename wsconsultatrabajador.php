<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["RutTrabajador"])){
        
		$RutTrabajador=$_GET["RutTrabajador"];
	
				
			$consulta="SELECT Trabajador.RutTrabajador  as Dni,
            Trabajador.IdTrabajador,
			Trabajador.Nombre,
			Trabajador.ApellidoPaterno,
			Trabajador.ApellidoMaterno,
			Trabajador.IdEmpresa,
            Contratos.IdActividad as IdOficio,
			acti.Nombre as oficio,
			E.Nombre as empresa,
			z.Nombre as zona
            FROM Trabajador 
            INNER JOIN EMPRESA E ON E.IdEmpresa=Trabajador.IdEmpresa
            INNER JOIN  Contratos   ON Trabajador.IdTrabajador = Contratos.IdTrabajador and Contratos.idempresa=Trabajador.idempresa	
			INNER JOIN Actividades acti ON Contratos.IdActividad=acti.IdActividad and acti.IdFamilia=Contratos.IdFamilia and acti.IdEmpresa=Contratos.IdEmpresa 
			LEFT JOIN Zona z ON z.IdEmpresa=Contratos.IdEmpresa and z.IdZona=Contratos.IdZona
			where Contratos.IndicadorVigencia='1' AND Trabajador.RutTrabajador='{$RutTrabajador}' ";
		
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