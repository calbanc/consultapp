<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 

	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["PLANILLA"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])&&isset($_GET["LLAVE"])&&isset($_GET["FECHA"])&&
    isset($_GET["HORA"])&&isset($_GET["TEMP"])&&isset($_GET["PLANILLA_DETALLE"])){
        

        $LLAVE=$_GET["LLAVE"];
        $PLANILLA=$_GET["PLANILLA"];
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];
        $TEMP=$_GET["TEMP"];
        $PLANILLA_DETALLE=$_GET["PLANILLA_DETALLE"];

        $consultaantes="SELECT LLAVE,PLANILLA,COD_TEM,COD_EMP FROM ANDROID_CTRL_PREFRIO_DETALLE WHERE LLAVE='{$LLAVE}' AND PLANILLA='{$PLANILLA}' AND COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}' ";
         
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
       
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            
             if($registross['LLAVE']==$LLAVE){

                $consultainsertado="SELECT * FROM ANDROID_CTRL_PREFRIO_DETALLE WHERE LLAVE='{$LLAVE}' AND PLANILLA='{$PLANILLA}' AND COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}'";
                $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                    $json[]=$registro;
                }
                
                
                echo json_encode($json);

                
            }
        }else{
            	 $consulta="INSERT INTO ANDROID_CTRL_PREFRIO_DETALLE(PLANILLA,COD_TEM,COD_EMP,LLAVE,FECHA,HORA,TEMP,PLANILLA_DETALLE)
                 VALUES ('{$PLANILLA}','{$COD_TEM}','{$COD_EMP}','{$LLAVE}','{$FECHA}','{$HORA}','{$TEMP}','{$PLANILLA_DETALLE}')";
            	
		        $resultado=sqlsrv_query($conexion,$consulta);
        
                if($resultado){
                      $consultainsertado="SELECT * FROM ANDROID_CTRL_PREFRIO_DETALLE WHERE LLAVE='{$LLAVE}' AND PLANILLA='{$PLANILLA}' AND COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}'";
                    $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                    while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                        $json[]=$registro;
                    }
                
                
                echo json_encode($json);
                }
                else{
                    $resulta["LLAVE"]='NO REGISTRA';
                    $json[]=$resulta;
                }
                    echo json_encode($json); 
            }               
	}else{
		$resultar["id"]='Ws no Retorna';
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

