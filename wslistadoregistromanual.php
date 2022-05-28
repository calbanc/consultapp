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
	if(isset($_GET["empresa"])&&isset($_GET["fecha"])){
        
	
		$empresa=$_GET["empresa"];
        $fecha=$_GET["fecha"];
     
		
		
		$consulta="SELECT convert(varchar, l.HORAINICIO,8) as 'HORAINICIO',CONVERT(VARCHAR,l.HORAFINAL,8) AS 'HORAFINAL',[TRABAJADOR]=t.ApellidoPaterno+' ' +t.ApellidoMaterno+' '+t.Nombre, z.Nombre AS 'ZONA',mr.DESCRIPCION as 'MOTIVO'
        FROM LecturasSmart l
        INNER JOIN Zona z on Z.IdEmpresa=l.IDEMPRESA and Z.IdZona=l.IdZona
        INNER JOIN MOTIVOS_REGISTRO mr on mr.IDEMPRESA=l.idempresa and mr.IDMOTIVO=l.idmotivo 
        INNER JOIN Trabajador t on t.IdTrabajador=l.IDTRABAJADOR and t.IdEmpresa=l.IDEMPRESA
        where l.IDEMPRESA='{$empresa}' and UsuarioReg='{$usuario}' AND l.FECHA='{$fecha}' and (EstacionInicio='MARCACION MANUAL APP' or EstacionFinal='MARCACION MANUAL APP' )
        ORDER BY l.FechaReg desc";
		
		
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
