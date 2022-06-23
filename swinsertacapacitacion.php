<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["LLAVE"])&&isset($_GET["IDEMPRESA"])&&isset($_GET["PLANILLA"])&&isset($_GET["ID_TEMA"])&&isset($_GET["FECHA"])&&
    isset($_GET["HORA_INICIO"])&&isset($_GET["HORA_TERMINO"])&&isset($_GET["TOTAL_HORAS"])
    &&isset($_GET["IDAREA"])&&isset($_GET["IdExpositor"])&&isset($_GET["IdInstitucion"])&&isset($_GET["IdLugar"])){
        

        $LLAVE=$_GET["LLAVE"];
        $IDEMPRESA=$_GET["IDEMPRESA"];
        $PLANILLA=$_GET["PLANILLA"];
        $ID_TEMA=$_GET["ID_TEMA"];
        $FECHA=$_GET["FECHA"];
        $HORA_INICIO=$_GET["HORA_INICIO"];
        $HORA_TERMINO=$_GET["HORA_TERMINO"];
        $TOTAL_HORAS=$_GET["TOTAL_HORAS"];
     
        $IDAREA=$_GET["IDAREA"];
        $IdExpositor=$_GET["IdExpositor"];
        $IdInstitucion=$_GET["IdInstitucion"];
        $IdLugar=$_GET["IdLugar"];  
        
        $consultaantes="SELECT LLAVE FROM ANDROID_CAPACITACION WHERE LLAVE='{$LLAVE}' ";
        

        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
      
       
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            
            if($registross['LLAVE']==$LLAVE){
                $consultainsertado="SELECT  LLAVE,IDEMPRESA,PLANILLA,ID_TEMA,CONVERT(VARCHAR,FECHA,23)AS FECHA,CONVERT(VARCHAR,HORA_INICIO,120)AS HORA_INICIO,
                CONVERT(VARCHAR,HORA_TERMINO,120)AS HORA_TERMINO,CONVERT(VARCHAR,TOTAL_HORAS,120)AS TOTAL_HORAS,IDAREA,IdExpositor,IdInstitucion,IdLugar
                 FROM ANDROID_CAPACITACION WHERE LLAVE='{$LLAVE}' ";
                $resultadoinsertado=sqlsrv_query($conexion,$consultainsertado);
                while($registro =sqlsrv_fetch_array($resultadoinsertado)){
                    $json[]=$registro;
                }
                
                
                echo json_encode($json);
                
            }
        
        }
        
        
        
         else{
             		
                $consulta="INSERT INTO ANDROID_CAPACITACION(LLAVE,IDEMPRESA,PLANILLA,ID_TEMA,FECHA,HORA_INICIO,HORA_TERMINO,TOTAL_HORAS,IDAREA,IdExpositor,IdInstitucion,IdLugar,SW_IMPORTADO) 
                VALUES ('{$LLAVE}','{$IDEMPRESA}','{$PLANILLA}','{$ID_TEMA}','{$FECHA}','{$HORA_INICIO}','{$HORA_TERMINO}','{$TOTAL_HORAS}','{$IDAREA}','{$IdExpositor}','{$IdInstitucion}','{$IdLugar}','0')";
                
                $resultado=sqlsrv_query($conexion,$consulta);
                
                if($resultado){
                    $consultainsertado="SELECT LLAVE,IDEMPRESA,PLANILLA,ID_TEMA,CONVERT(VARCHAR,FECHA,23)AS FECHA,CONVERT(VARCHAR,HORA_INICIO,120)AS HORA_INICIO,
                    CONVERT(VARCHAR,HORA_TERMINO,120)AS HORA_TERMINO,CONVERT(VARCHAR,TOTAL_HORAS,120)AS TOTAL_HORAS,IDAREA,IdExpositor,IdInstitucion,IdLugar 
                    FROM ANDROID_CAPACITACION WHERE LLAVE='{$LLAVE}' ";
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



