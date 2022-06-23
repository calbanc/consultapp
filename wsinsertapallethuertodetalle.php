<?PHP
$hostname_localhost="192.168.2.210";

    
$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["IdEmpresa"])
    &&isset($_GET["IdTrabajador"])
    &&isset($_GET["CANTIDAD"])
   ){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $LOTE=$_GET["LOTE"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $IdTrabajador=$_GET["IdTrabajador"];
        $CANTIDAD=$_GET["CANTIDAD"];

        $consultaantes="SELECT IdTrabajador,IdEmpresa,LOTE FROM COSECHA_HUERTO_DETALLE WHERE LOTE='{$LOTE}' AND IdEmpresa='{$IdEmpresa}' and IdTrabajador='{$IdTrabajador}' and COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ";
        
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['IdTrabajador']==$IdTrabajador && $registross['IdEmpresa']==$IdEmpresa && $registross['LOTE']==$LOTE ){
                $json[]=$registross;
                echo json_encode($json); 
            }      
        }else{
            $consulta="INSERT INTO COSECHA_HUERTO_DETALLE(COD_TEM,COD_EMP,LOTE,IdEmpresa,IdTrabajador,CANTIDAD)
            VALUES ('{$COD_TEM}','{$COD_EMP}','{$LOTE}','{$IdEmpresa}','{$IdTrabajador}','{$CANTIDAD}')";
            
            $resultado=sqlsrv_query($conexion,$consulta);
            
            if($resultado){ 
                $consultadespues="SELECT IdTrabajador,IdEmpresa,LOTE FROM COSECHA_HUERTO_DETALLE WHERE LOTE='{$LOTE}' AND IdEmpresa='{$IdEmpresa}' and IdTrabajador='{$IdTrabajador}' and COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ";
            
                $resultadodespues=sqlsrv_query($conexion,$consultadespues);
                if($resultadosasd=sqlsrv_fetch_array($resultadodespues)){
                    $json[]=$resultadosasd;
                    echo json_encode($json); 
                }            
            }else{
                $resulta["LOTE"]='NO REGISTRA';
                 $json[]=$resulta;
                 echo json_encode($json);
            }


        }


        }else{
        $resultar["id"]='FALTAN DATOS';
        $json[]=$resultar;
        echo json_encode($json);
    }

}else{
	echo "CONEXION FALLIDA";
}

	
?>