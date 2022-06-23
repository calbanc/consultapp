<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	$info=array("Database"=>"erpfrusys","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");



	$conexion = sqlsrv_connect($hostname_localhost,$info);

	if($conexion){
		$json=array();
		if(isset($_GET["IDEMPRESA"])){
			
			$IDEMPRESA=$_GET["IDEMPRESA"];
			
			$consulta="SELECT z.idzona,z.nombre, P.COD_PRE,pr.ZON,P.DESCRIPCION ,PR.COD_PRO,AP.IDUSUARIO,T.IDTRABAJADOR,T.NOMBRE,T.ApellidoPaterno,T.ApellidoMaterno
            FROM BSIS_REM_AFR.DBO.ZONA Z
            INNER JOIN BSIS_REM_AFR.DBO.EMPRESA E ON Z.IDEMPRESA=E.IDEMPRESA
            INNER JOIN ERPFRUSYS.DBO.PREDIOS P ON P.COD_EMP=E.COD_EMP_CONT AND P.COD_PRE=Z.IDZONA AND E.COD_TEM=P.COD_TEM 
            inner join erpfrusys.dbo.PRODUCTORES pr on pr.COD_EMP=P.COD_EMP and pr.COD_TEM=P.COD_TEM and pr.COD_PRO=P.COD_PRO AND pr.SW_REMU=1
            INNER JOIN erpfrusys.dbo.ANDROID_PARAMETROS AP ON AP.COD_EMP=PR.COD_EMP AND AP.COD_TEM=PR.COD_TEM AND PR.ZON=AP.IDZONA
            INNER JOIN BSIS_REM_AFR.DBO.TRABAJADOR t on t.USUARIOSIS=AP.IDUSUARIO
			inner join BSIS_REM_AFR.DBO.Contratos c on t.idtrabajador=c.idtrabajador and C.IndicadorVigencia=1
            WHERE Z.IDEMPRESA='{$IDEMPRESA}'";
            
			
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
		$resultar["message"]='CONEXION';
			$json[]=$resultar;
			echo json_encode($json);
	}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}	
?>