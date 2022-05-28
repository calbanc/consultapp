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
	if(isset($_GET["IDEMPRESA"])&&isset($_GET["IDTEMPORADA"])){
        
	
		$IDEMPRESA=$_GET["IDEMPRESA"];
		$IDTEMPORADA=$_GET["IDTEMPORADA"];

		
				
        $consulta="SELECT HA.PLANILLA,CONVERT(VARCHAR,HA.FECHA,103) AS 'FECHA',HA.IDZONA,Z.Nombre as 'ZONA',A.NOMBRE as 'AREA',CL.Descripcion AS 'LUGAR',HA.DESCRIPCION_HALLAZGO AS 'DESCRIPCION',
        HA.MEDIDAS_HALLAZGO AS 'MEDIDA',HA.CAUSAS AS 'CAUSAS',PH.Descripcion  AS 'PLAZO',NH.Descripcion AS 'NIVEL',HA.TURNO,HA.CONSECUENCIAS,HA.IDTRABAJADOR,
        [SUPERVISOR]=TR.ApellidoPaterno+' '+TR.ApellidoMaterno+' '+TR.Nombre,HA.IDFOTO
        FROM HALLAZGOS_ANDROID HA
        INNER JOIN Zona Z on z.IdEmpresa=ha.IDEMPRESA and HA.IDZONA=Z.IdZona
        INNER JOIN AREAS A on HA.IDAREA=A.IDAREA AND HA.IDEMPRESA=A.IDEMPRESA
        INNER JOIN CAPACITACION_LUGAR CL on CL.IdEmpresa=HA.IDEMPRESA AND CL.IdLugar=HA.IDLUGAR
        LEFT JOIN PLAZOS_HALLAZGOS PH on PH.IdEmpresa=HA.IDEMPRESA AND PH.IdPlazoHallazgo=HA.IDPLAZOHALLAZGO
        LEFT JOIN NIVEL_HALLAZGOS NH on NH.IdEmpresa=HA.IDEMPRESA and NH.IdNivelHallazgo=HA.IDNIVELHALLAZGO
        INNER JOIN TRABAJADOR TR ON TR.UsuarioSis=HA.USUARIO
        WHERE HA.IDEMPRESA='{$IDEMPRESA}' AND HA.IDTEMPORADA='{$IDTEMPORADA}' AND HA.USUARIO='{$usuario}' AND HA.ESTADO='0'";
		
		

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