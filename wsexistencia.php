<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        
		
		$consulta="SELECT     EXISTENCIA.FILA, EXISTENCIA.PISO, EXISTENCIA.COD_CAM, EXISTENCIA.COD_BANDA, EXISTENCIA.COD_FRI,
                              EXISTENCIA.LOTE, CAMARAS.DES_CAM, BANDAS.DES_BANDA, EXISTENCIA.COD_TEM, EXISTENCIA.COD_EMP
        FROM         EXISTENCIA INNER JOIN
                              CAMARAS ON EXISTENCIA.COD_EMP = CAMARAS.COD_EMP INNER JOIN
                              BANDAS ON EXISTENCIA.COD_FRI = BANDAS.COD_FRI AND EXISTENCIA.COD_EMP = BANDAS.COD_EMP AND 
                              EXISTENCIA.COD_TEM = BANDAS.COD_TEM AND EXISTENCIA.COD_CAM = BANDAS.COD_CAM AND 
                              EXISTENCIA.COD_BANDA = BANDAS.COD_BANDA AND CAMARAS.COD_EMP = BANDAS.COD_EMP AND
                              CAMARAS.COD_TEM = BANDAS.COD_TEM AND CAMARAS.COD_FRI = BANDAS.COD_FRI AND 
                              CAMARAS.COD_CAM = BANDAS.COD_CAM
        WHERE     EXISTENCIA.COD_EMP = '{$COD_EMP}' AND EXISTENCIA.COD_TEM = '{$COD_TEM}'
        GROUP BY EXISTENCIA.FILA, EXISTENCIA.PISO, EXISTENCIA.COD_CAM, EXISTENCIA.COD_BANDA, EXISTENCIA.COD_FRI, 
                              EXISTENCIA.LOTE, CAMARAS.DES_CAM, BANDAS.DES_BANDA, EXISTENCIA.COD_TEM, EXISTENCIA.COD_EMP";
		
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