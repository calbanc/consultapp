<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 	 

	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["PLANILLA"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])&&isset($_GET["LOTE"])&&isset($_GET["FECHAINICIO"])&&isset($_GET["FECHATERMINO"])&&
    isset($_GET["HORA_INICIO"])&&isset($_GET["HORA_TERMINO"])&&isset($_GET["TEMP_INICIO"])&&isset($_GET["TEMP_TERMINO"])&&isset($_GET["COD_FRI"])
    &&isset($_GET["COD_CAM"])&&isset($_GET["PLANILLA_DETALLE"])){
        

        $PLANILLA=$_GET["PLANILLA"];
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $LOTE=$_GET["LOTE"];
        $FECHAINICIO=$_GET["FECHAINICIO"];
        $FECHATERMINO=$_GET["FECHATERMINO"];
        $HORA_INICIO=$_GET["HORA_INICIO"];    
        $HORA_TERMINO=$_GET["HORA_TERMINO"];
        $TEMP_INICIO=$_GET["TEMP_INICIO"];
        $TEMP_TERMINO=$_GET["TEMP_TERMINO"];
        $COD_FRI=$_GET["COD_FRI"];
        $COD_CAM=$_GET["COD_CAM"];
        $PLANILLA_DETALLE=$_GET["PLANILLA_DETALLE"];

       

      
        
        $consultaantes="SELECT PLANILLA,COD_TEM,COD_EMP,LOTE FROM ANDROID_CTRL_PREFRIO WHERE PLANILLA='{$PLANILLA}' AND COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}' AND LOTE='{$LOTE}'";
       
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['LOTE']==$LOTE){
                $consultainsertado="SELECT * FROM ANDROID_CTRL_PREFRIO WHERE PLANILLA='{$PLANILLA}' AND COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}' AND LOTE='{$LOTE}'";
                $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                    $json[]=$registro;
                }        
                echo json_encode($json);            
            }
        
        }else{
            
            if($FECHATERMINO=='NULL' || $HORA_TERMINO=='NULL' || $TEMP_TERMINO=='NULL'){
                $consulta="INSERT INTO ANDROID_CTRL_PREFRIO (PLANILLA, COD_TEM, COD_EMP, LOTE, FECHAINICIO, HORA_INICIO, TEMP_INICIO, COD_FRI, COD_CAM,PLANILLA_DETALLE,IdUsuario)          
            VALUES('{$PLANILLA}', '{$COD_TEM}', '{$COD_EMP}', '{$LOTE}', '{$FECHAINICIO}',  '{$HORA_INICIO}', '{$TEMP_INICIO}', '{$COD_FRI}', '{$COD_CAM}','{$PLANILLA_DETALLE}','{$usuario}')";
             
            }else{
                $consulta="INSERT INTO ANDROID_CTRL_PREFRIO (PLANILLA, COD_TEM, COD_EMP, LOTE, FECHAINICIO, FECHATERMINO, HORA_INICIO, HORA_TERMINO, TEMP_INICIO, TEMP_TERMINO, COD_FRI, COD_CAM,PLANILLA_DETALLE,IdUsuario)          
                VALUES('{$PLANILLA}', '{$COD_TEM}', '{$COD_EMP}', '{$LOTE}', '{$FECHAINICIO}', '{$FECHATERMINO}', '{$HORA_INICIO}', '{$HORA_TERMINO}', '{$TEMP_INICIO}', '{$TEMP_TERMINO}', '{$COD_FRI}', '{$COD_CAM}','{$PLANILLA_DETALLE}','$usuario')";
            }
            
           
            $resultado=sqlsrv_query($conexion,$consulta);
            
             if($resultado){
                $consultainsertado="SELECT * FROM ANDROID_CTRL_PREFRIO WHERE PLANILLA='{$PLANILLA}' AND COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}' AND LOTE='{$LOTE}'";
                $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                    $json[]=$registro;
                }
                
                
                echo json_encode($json);
            }
            else{
                $resulta["PLANILLA"]='NO REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
            
        }
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

