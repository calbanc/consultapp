<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["LOTE"])){
        
        $LOTE=$_GET["LOTE"];
        $COD_EMP=$_GET["COD_EMP"];
		$COD_TEM=$_GET["COD_TEM"];
       
		
		$consulta="  SELECT P.LOTE,P.COD_TEM,TEM.DESCRIPCION AS TEMPORADA,P.COD_EMP,EMP.NOM_EMP AS EMPRESA,P.COD_PRO,PRO.NOM_PRO AS PRODUCTOR,
        P.COD_PRE,PRE.DESCRIPCION AS PREDIO,P.COD_CUA,CUA.DESCRIPCION AS CUARTEL,PREINS.COD_INSCRIPCION AS LUGAR_PRODUCCION,
        P.COD_ESP,ESP.NOM_ESP AS ESPECIE,P.COD_VAR,VAR.NOM_VAR AS VARIEDAD,P.COD_CAL,P.COD_ENV,ENV.NOM_ENV AS ENVASE,Convert(varchar,P.FECHA_COSECHA,120) as fecha,P.CANTIDAD,P.ACOPIO,P.CATEGORIA,P.TIPO_COSECHA,P.TOTAL_KILOS,P.KILOS
        FROM COSECHA_HUERTO P
        INNER JOIN TEMPORADAS TEM ON TEM.COD_TEM=P.COD_TEM AND TEM.COD_EMP=P.COD_EMP
        INNER JOIN EMPRESAS EMP ON EMP.COD_EMP=P.COD_EMP
        INNER JOIN PRODUCTORES PRO ON PRO.COD_EMP=P.COD_EMP AND PRO.COD_TEM=P.COD_TEM AND PRO.COD_PRO=P.COD_PRO
        INNER JOIN PREDIOS PRE ON PRE.COD_EMP=P.COD_EMP AND PRE.COD_TEM=P.COD_TEM AND PRE.COD_PRO=P.COD_PRO AND PRE.COD_PRE=P.COD_PRE
        INNER JOIN CUARTELES CUA ON CUA.COD_EMP=P.COD_EMP AND CUA.COD_TEM=P.COD_TEM AND CUA.COD_PRO=P.COD_PRO AND CUA.COD_PRE=P.COD_PRE AND CUA.COD_CUA=P.COD_CUA
        LEFT JOIN PREDIOS_INSPECCION PREINS ON PREINS.COD_EMP=P.COD_EMP AND PREINS.COD_TEM=P.COD_TEM AND PREINS.COD_PRO=P.COD_PRO AND PREINS.COD_PRE=P.COD_PRE AND PREINS.COD_CUA=P.COD_CUA
        INNER JOIN ESPECIE ESP ON ESP.COD_EMP=P.COD_EMP AND ESP.COD_TEM=P.COD_TEM AND ESP.COD_ESP=P.COD_ESP
        INNER JOIN VARIEDAD VAR ON VAR.COD_VAR=P.COD_VAR AND VAR.COD_ESP=P.COD_ESP AND VAR.COD_TEM=P.COD_TEM AND VAR.COD_EMP=P.COD_EMP
        INNER JOIN CALIBRES CAL ON CAL.COD_EMP=P.COD_EMP AND CAL.COD_TEM=P.COD_TEM AND CAL.COD_ESP=P.COD_ESP AND CAL.COD_CAL=P.COD_CAL
        INNER JOIN ENVASE ENV ON ENV.COD_ENV=P.COD_ENV AND ENV.COD_TEM=P.COD_TEM AND ENV.COD_EMP=P.COD_EMP
        WHERE P.LOTE='{$LOTE}' AND P.COD_TEM='{$COD_TEM}' AND P.COD_EMP='{$COD_EMP}' ";
		
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