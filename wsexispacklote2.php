<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.12345","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_PACK"])&&isset($_GET["LOTE"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $COD_PACK=$_GET["COD_PACK"];
        $LOTE=$_GET["LOTE"];
		$nlote=explode("-",$LOTE);
        $LOTE=$nlote[0];
        
		$consulta="SELECT E.COD_TEM,E.COD_EMP,CONVERT(varchar,E.FECHA_RPA,23) as FECHA,E.COD_PACK,E.COD_PRO,E.COD_FRI,E.COD_ESP,E.COD_VAR,E.LOTE,E.COD_ENV,E.ZON,E.CANTIDAD,E.KILOS,E.TOTAL_KILOS,E.COD_PRE,E.COD_CUA
        FROM EXISPACK E 
        INNER JOIN PRODUCTORES  P ON  E.COD_PRO = P.COD_PRO AND  E.COD_TEM = P.COD_TEM AND  E.COD_EMP = P.COD_EMP 
        INNER JOIN ESPECIE ES ON  E.COD_ESP = ES.COD_ESP AND  E.COD_TEM = ES.COD_TEM AND  E.COD_EMP = ES.COD_EMP  
        INNER JOIN VARIEDAD  V ON  E.COD_ESP = V.COD_ESP AND  E.COD_VAR = V.COD_VAR AND  E.COD_TEM = V.COD_TEM AND  E.COD_EMP = V.COD_EMP  
        INNER JOIN FRIOS F ON  E.COD_FRI = F.COD_FRI AND  E.COD_TEM = F.COD_TEM AND  E.COD_EMP = F.COD_EMP 
        where E.COD_TEM='{$COD_TEM}' AND E.COD_EMP='{$COD_EMP}' AND E.COD_PACK='{$COD_PACK}' AND E.LOTE='{$LOTE}'";
		
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