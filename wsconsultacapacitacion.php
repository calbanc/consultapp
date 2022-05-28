<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["DNI"])){
        
       
        $DNI=$_GET["DNI"];
		
		$consulta="SELECT CD.IDEMPRESA,TC.TEMA,CD.DNI,CD.NOMBRES,CD.APELLIDOS,CD.CARGO,CD.COD_BUS,CONVERT(VARCHAR,CP.FECHA,103) AS 'FECHA',CP.HORA_INICIO,CP.HORA_TERMINO,CONVERT(VARCHAR,CP.TOTAL_HORAS,8) AS 'TOTAL_HORAS',
        CE.Descripcion AS 'EXPOSITOR',CI.Descripcion AS 'INSTITUCION',CL.Descripcion AS 'LUGAR',ZN.Nombre AS 'ZONA'
        FROM CAPACITACION CP
        INNER JOIN CAPACITACION_DETALLE CD ON CD.IDEMPRESA=CP.IDEMPRESA AND CD.PLANILLA=CP.PLANILLA AND CD.ID_TEMA=CP.ID_TEMA
        INNER JOIN TIPO_CAPACITACION TC ON TC.IDEMPRESA=CD.IDEMPRESA AND TC.ID_TEMA=CD.ID_TEMA
        INNER JOIN CAPACITACION_EXPOSITOR CE ON CD.IDEMPRESA=CP.IdEmpresa AND CP.IdExpositor=CE.IdExpositor
        INNER JOIN CAPACITACION_INSTITUCION CI ON CI.IdEmpresa=CP.IDEMPRESA AND CI.IdInstitucion=CP.IdInstitucion
        LEFT JOIN CAPACITACION_LUGAR CL ON CP.IdLugar=CL.IdLugar AND CP.IDEMPRESA=CL.IdEmpresa
        LEFT JOIN Zona ZN ON ZN.IdZona=CP.IdZona AND ZN.IdEmpresa=CP.IdEmpresa
        WHERE CD.DNI='{$DNI}'
        ORDER BY FECHA DESC ";
		
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