<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_PACK"])&&isset($_GET["PLANILLA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $COD_PACK=$_GET["COD_PACK"];
        $PLANILLA=$_GET["PLANILLA"];
     
		
		$consulta="SELECT  rece.COD_TEM,rece.COD_EMP,rece.PLANILLA,CONVERT(varchar,rece.FECHA_RPA,23) AS FECHA_RECEPCION,rece.COD_PACK,pack.NOM_PACK,rece.COD_PRO,
        pro.NOM_PRO,rece.COD_ESP,esp.NOM_ESP,rece.COD_VAR,va.NOM_VAR,rece.CANTIDAD,rece.COD_PRE,pre.DESCRIPCION AS NOM_PRE,rece.COD_CUA,
        cua.DESCRIPCION AS NOM_CUA,CONVERT(varchar,trece.FECHA_COSECHA,23) as FECHA_COSECHA,rece.LOTE
        from recepack rece
        INNER JOIN TIT_RECEPACK trece ON rece.PLANILLA=trece.PLANILLA AND rece.COD_EMP=trece.COD_EMP AND rece.COD_TEM=trece.COD_TEM AND trece.COD_PACK=rece.COD_PACK
        INNER JOIN PRODUCTORES pro on rece.COD_EMP=pro.COD_EMP AND rece.COD_TEM=pro.COD_TEM AND rece.COD_PRO=pro.COD_PRO
        INNER JOIN ESPECIE esp on rece.COD_EMP=esp.COD_EMP AND rece.COD_TEM=esp.COD_TEM and rece.COD_ESP=esp.COD_ESP
        INNER JOIN VARIEDAD va on rece.COD_EMP=va.COD_EMP and rece.COD_TEM=va.COD_TEM and rece.COD_ESP=va.COD_ESP AND rece.COD_VAR=va.COD_VAR
        INNER JOIN PREDIOS pre ON rece.COD_EMP=pre.COD_EMP AND rece.COD_TEM=pre.COD_TEM and rece.COD_PRO=pre.COD_PRO and rece.COD_PRE=pre.COD_PRE
        INNER JOIN CUARTELES cua ON cua.COD_EMP=rece.COD_EMP and cua.COD_TEM=rece.COD_TEM and cua.COD_PRO=rece.COD_PRO and cua.COD_PRE=rece.COD_PRE and cua.COD_CUA=rece.COD_CUA
        INNER JOIN PACKINGS pack ON rece.COD_EMP=pack.COD_EMP and rece.COD_TEM=pack.COD_TEM and rece.COD_PACK=pack.COD_PACK
        WHERE  rece.COD_EMP='{$COD_EMP}' AND rece.COD_TEM='{$COD_TEM}' AND rece.COD_PACK='{$COD_PACK}' and rece.PLANILLA='{$PLANILLA}'";
		
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