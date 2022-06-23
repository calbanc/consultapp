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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["CANTIDAD"])&&isset($_GET["IDTRABAJADOR"])
    &&isset($_GET["FECHA"])&&isset($_GET["IDEMPRESATRAB"])&&isset($_GET["COD_ENV"])&&isset($_GET["PLANILLA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        $FECHA=$_GET["FECHA"];
        $IDEMPRESATRAB=$_GET["IDEMPRESATRAB"];
        $PLANILLA=$_GET["PLANILLA"];
        $COD_ENV=$_GET["COD_ENV"];
        
        if(empty($PLANILLA)){
            $consultaplanilla="SELECT ISNULL(max(planilla),0)+1 AS 'PLANILLA' from ANDROID_COSECHA_HUERTO_DETALLE WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'";
          
            $query=sqlsrv_query($conexion,$consultaplanilla);
            if($registro =sqlsrv_fetch_array($query)){
                $PLANILLA=$registro['PLANILLA'];
               
            }

        }

       
        $insert="INSERT INTO ANDROID_COSECHA_HUERTO_DETALLE(COD_EMP,COD_TEM,IDEMPRESATRAB,IDTRABAJADOR,COD_ENV,PLANILLA,FECHA,CANTIDAD,USUARIO)VALUES
            ('{$COD_EMP}','{$COD_TEM}','{$IDEMPRESATRAB}','{$IDTRABAJADOR}','{$COD_ENV}','{$PLANILLA}','{$FECHA}','{$CANTIDAD}','{$usuario}') ";   
    
       
		$resultado=sqlsrv_query($conexion,$insert);

		if($resultado){
            $resultar["PLANILLA"]=$PLANILLA;
            $json[]=$resultar;
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