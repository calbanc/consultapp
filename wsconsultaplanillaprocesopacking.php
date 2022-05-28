<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["PLANILLA"])&&isset($_GET["ZON"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PLANILLA=$_GET["PLANILLA"];
        $ZON=$_GET["ZON"];
		
		$consulta="SELECT DISTINCT PACKINGS.COD_PACK, 
        PACKINGS.NOM_PACK,  
        PRODUCTORES.COD_PRO, 
        PRODUCTORES.NOM_PRO, 
        ESPECIE.COD_ESP,  
        ESPECIE.NOM_ESP,
        CONVERT(VARCHAR,PK.FECHA_RPA,23) AS FECHA_RPA , 
        PK.COD_VAR , 
        J.DESCRIPCION AS JORNADA, 
        TL.NOM_LINEA 
        FROM TIT_PROCEPACK  PK 
        INNER JOIN PRODUCTORES ON  PK.COD_PRO = PRODUCTORES.COD_PRO AND  PK.COD_TEM = PRODUCTORES.COD_TEM AND  PK.COD_EMP = PRODUCTORES.COD_EMP  
        INNER JOIN ESPECIE ON  PK.COD_ESP = ESPECIE.COD_ESP AND  PK.COD_TEM = ESPECIE.COD_TEM AND  PK.COD_EMP = ESPECIE.COD_EMP  
        INNER JOIN PACKINGS ON  PK.COD_PACK = PACKINGS.COD_PACK AND  PK.COD_TEM = PACKINGS.COD_TEM AND  PK.COD_EMP = PACKINGS.COD_EMP  
        LEFT JOIN JORNADAPACK J ON  PK.COD_JORNADA = J.COD_JORNADA AND  PK.COD_TEM = J.COD_TEM AND  PK.COD_EMP = J.COD_EMP  
        LEFT JOIN TIPOLINEAPK TL ON  PK.COD_LINEA = TL.COD_LINEA AND  PK.COD_TEM = TL.COD_TEM AND  PK.COD_EMP = TL.COD_EMP AND TL.COD_ZON=PK.ZON 
        WHERE PK.PLANILLA = '{$PLANILLA}' AND  PK.COD_TEM = '{$COD_TEM}' AND  PK.COD_EMP = '{$COD_EMP}' AND  PK.ZON= '{$ZON}' ";


        $consulta1="SELECT PLU, COD_VAR, COD_VAR_ETI FROM PROPACKLOTE  WHERE PLANILLA = '{$PLANILLA}' AND ZON='{$ZON}' AND COD_EMP = '{$COD_EMP}' AND COD_TEM = '{$COD_TEM}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}
		echo json_encode($json);
			
		$resultado2=sqlsrv_query($conexion,$consulta1);
		
		while($registro2 =sqlsrv_fetch_array($resultado2)){
			$json2[]=$registro2;
		}
		echo json_encode($json2);

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>