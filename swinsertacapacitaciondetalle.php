<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["CODIGO_TRABAJADOR"])&&isset($_GET["IDEMPRESA"])&&isset($_GET["PLANILLA"])&&isset($_GET["ID_TEMA"])&&isset($_GET["COD_BUS"])){
        

       
        $IDEMPRESA=$_GET["IDEMPRESA"];
        $PLANILLA=$_GET["PLANILLA"];
        $ID_TEMA=$_GET["ID_TEMA"];
        $CODIGO_TRABAJADOR=$_GET["CODIGO_TRABAJADOR"];
        $COD_BUS=$_GET["COD_BUS"];  

  
        
        $consultaantes="SELECT IDEMPRESA,PLANILLA,ID_TEMA,CODIGO_TRABAJADOR FROM ANDROID_CAPACITACION_DETALLE  WHERE IDEMPRESA='{$IDEMPRESA}' AND PLANILLA='{$PLANILLA}' AND ID_TEMA='{$ID_TEMA}' AND CODIGO_TRABAJADOR='{$CODIGO_TRABAJADOR}' ";
        
      
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
      
       
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            
            if($registross['IDEMPRESA']==$IDEMPRESA && $registross['PLANILLA']==$PLANILLA && $registross['ID_TEMA']==$ID_TEMA && $registross['CODIGO_TRABAJADOR']==$CODIGO_TRABAJADOR ){
                $consultainsertado="SELECT * FROM ANDROID_CAPACITACION_DETALLE WHERE IDEMPRESA='{$IDEMPRESA}' AND PLANILLA='{$PLANILLA}' AND ID_TEMA='{$ID_TEMA}' AND CODIGO_TRABAJADOR='{$CODIGO_TRABAJADOR}' ";
                
                $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                    $json[]=$registro;
                }
                echo json_encode($json);
                
            }
        
        }   
         else{
             		
                $consulta="INSERT INTO ANDROID_CAPACITACION_DETALLE(IDEMPRESA,PLANILLA,ID_TEMA,CODIGO_TRABAJADOR,IndicadorVigencia,COD_BUS) 
                VALUES ('{$IDEMPRESA}','{$PLANILLA}','{$ID_TEMA}','{$CODIGO_TRABAJADOR}','1','{$COD_BUS}')";
               
                
                $resultado=sqlsrv_query($conexion,$consulta);
                
                if($resultado){
                    $consultainsertado="SELECT * FROM ANDROID_CAPACITACION_DETALLE WHERE IDEMPRESA='{$IDEMPRESA}' AND PLANILLA='{$PLANILLA}' AND ID_TEMA='{$ID_TEMA}' AND CODIGO_TRABAJADOR='{$CODIGO_TRABAJADOR}' ";
                $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                    $json[]=$registro;
                }
            
            
            echo json_encode($json);
            }
            

        }
     

       
	}else{
		$resultar["id"]='Faltan datos';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>

