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
    if(isset($_GET["COD_TEM"])
    &&isset($_GET["COD_EMP"])
    &&isset($_GET["COD_FRI"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
       
        $COD_FRI=$_GET["COD_FRI"];
     
       $consulta=" SELECT ACP.PLANILLA,COUNT(ACP.LOTE) AS 'CANTIDAD',CONVERT(VARCHAR,ACP.FECHAINICIO,23)AS 'FECHAINICIO',CONVERT(VARCHAR,ACP.HORA_INICIO,8) as 'HORA_INICIO',
       ACP.TEMP_INICIO,ACP.IdUsuario,[FRIO]=ACP.COD_FRI+'-'+NOM_FRI,[CAMARA]=ACP.COD_CAM+'-'+DES_CAM,ACP.COD_EMP,ACP.COD_TEM,ACP.PLANILLA_DETALLE
       FROM ANDROID_CTRL_PREFRIO ACP
       INNER JOIN FRIOS FR ON ACP.COD_EMP=FR.COD_EMP AND ACP.COD_TEM=FR.COD_TEM AND ACP.COD_FRI=FR.COD_FRI
       INNER JOIN CAMARAS CAM ON CAM.COD_EMP=ACP.COD_EMP AND CAM.COD_TEM=ACP.COD_TEM AND CAM.COD_FRI=ACP.COD_FRI AND CAM.COD_CAM=ACP.COD_CAM
       WHERE ACP.COD_EMP='{$COD_EMP}' AND ACP.COD_TEM='{$COD_TEM}' AND ACP.COD_FRI='{$COD_FRI}' AND ACP.FECHATERMINO IS NULL AND HORA_TERMINO IS NULL
       GROUP BY ACP.PLANILLA,ACP.FECHAINICIO,ACP.HORA_INICIO,ACP.TEMP_INICIO,ACP.IdUsuario,ACP.COD_FRI,FR.NOM_FRI,
       ACP.COD_CAM,CAM.DES_CAM,ACP.COD_EMP,ACP.COD_TEM,ACP.PLANILLA_DETALLE";
        
        $resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

       

        }else{
        $resultar["id"]='FALTAN DATOS';
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