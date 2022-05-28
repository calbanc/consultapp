<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDTEMPORADA"])){
        
        $IDTEMPORADA=$_GET["IDTEMPORADA"];
		$IDEMPRESA=$_GET["IDEMPRESA"];
		
		$consulta=" SELECT T.ApellidoPaterno + ' ' + T.ApellidoMaterno + ' ' + T.Nombre AS Trabajador,T.IdTrabajador AS codigo, C.FECHA,  S.DES_SITEM AS Material,
                           C.CANTIDAD  as Cantidad, C.TIPO, CASE WHEN e.DECIMAL = 0 THEN REPLACE(REPLACE(CONVERT(varchar(14), CAST(t .RutTrabajador AS money), 1),
                           '.00', ''), ',', '.') ELSE REPLACE(REPLACE(CONVERT(varchar(14), CAST(REPLICATE('0', Td.LARGO - LEN(t .RUTTRABAJADOR))
                           + LEFT(t.RUTTRABAJADOR, Td.LARGO) AS NVARCHAR(20)), 1), '.00', ''), ',', '.') END AS RutTrabajador,C.MOTIVO, ZL.Nombre AS [ZONALABORES]
                      FROM CTACTE_TRABAJADOR_MATERIAL AS C WITH (NOLOCK) INNER JOIN EMPRESAS AS E WITH (NOLOCK) ON E.COD_EMP = C.COD_EMP INNER JOIN
                           SUBITEM AS S WITH (NOLOCK) ON S.COD_EMP = C.COD_EMP AND S.COD_TEM = C.COD_TEM AND S.SUBITEM = C.SUBITEM INNER JOIN
                           AGRUPACION AS A WITH (NOLOCK) ON S.COD_EMP = A.COD_EMP AND S.COD_TEM = A.COD_TEM AND S.COD_AGRUP = A.COD_AGRUP INNER JOIN
                           bsis_rem_afr.dbo.Trabajador AS T WITH (NOLOCK) ON T.IdEmpresa = E.ID_EMPRESA_REM AND T.IdTrabajador = C.IDTRABAJADOR INNER JOIN
                           bsis_rem_afr.dbo.TipoDctoIden AS Td WITH (NOLOCK) ON Td.IdEmpresa = T.IdEmpresa AND Td.IdTipoDctoIden = T.IdTipoDctoIden 
                           LEFT OUTER JOIN bsis_rem_afr.dbo.Zona AS ZL WITH (NOLOCK) ON T.IdEmpresa = ZL.IdEmpresa AND T.IdZonaLabores = ZL.IdZona
                     where C.TIPO='Entrega' and C.COD_TEM='{$IDTEMPORADA}' and C.COD_EMP IN ('ARAP','FORT')";
		
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


