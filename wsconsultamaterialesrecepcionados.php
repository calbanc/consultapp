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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDZONA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $IDZONA=$_GET["IDZONA"];
		$sqlwhere="";
		if($IDZONA=='TODOS'){

		}else{
			$sqlwhere.="  AND ARECP.ZON='{$IDZONA}'";
		}

		$consulta=" SELECT DISTINCT ARECP.SUBITEM,MAT.DES_SITEM
        FROM RECEPCIONMATERIALES ARECP
        INNER JOIN SUBITEM MAT ON MAT.COD_EMP=ARECP.COD_EMP AND MAT.COD_TEM=ARECP.COD_TEM AND ARECP.SUBITEM=MAT.SUBITEM
        WHERE ARECP.COD_EMP='{$COD_EMP}' AND ARECP.COD_TEM='{$COD_TEM}' ".$sqlwhere;

        

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