<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["PLANILLA"])&&isset($_GET["IDUSUARIO"])&&isset($_GET["FECHA"])&&isset($_GET["IDEMPRESA"])&&
    isset($_GET["IDTRABAJADOR"])&&isset($_GET["COD_MAQ"])&&isset($_GET["SUBITEM"])&&isset($_GET["CANTIDAD"])&&isset($_GET["ODOMETRO"])&&isset($_GET["HOROMETRO"])
    &&isset($_GET["VERSION"])&&isset($_GET["LLAVE"])&&isset($_GET["TIPO_CARGA"])&&isset($_GET["FECHA_ACTUALIZACION"])&&isset($_GET["CANTIDAD_SALDO"])){
        

        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PLANILLA=$_GET["PLANILLA"];
        $IDUSUARIO=$_GET["IDUSUARIO"];
        $FECHA=$_GET["FECHA"];
        $IDEMPRESA=$_GET["IDEMPRESA"];
        $IDTRABAJADOR=$_GET["IDTRABAJADOR"];    
        $COD_MAQ=$_GET["COD_MAQ"];
        $SUBITEM=$_GET["SUBITEM"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $ODOMETRO=$_GET["ODOMETRO"];
        $HOROMETRO=$_GET["HOROMETRO"];
        $VERSION=$_GET["VERSION"];
        $LLAVE=$_GET["LLAVE"];
        $TIPO_CARGA=$_GET["TIPO_CARGA"];
        $FECHA_ACTUALIZACION=$_GET["FECHA_ACTUALIZACION"];
        $CANTIDAD_SALDO=$_GET["CANTIDAD_SALDO"];

        $timestamp = strtotime($FECHA_ACTUALIZACION);

        $fechacambiada=date("d/m/Y H:i:s",$timestamp);
        

        $consulta1="SELECT IDZONA,COD_BOD FROM ANDROID_PARAMETROS WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$IDUSUARIO}' ";
  

        $resultado2=sqlsrv_query($conexion,$consulta1);
        $registros=sqlsrv_fetch_array($resultado2);
        $idzona=$registros['IDZONA'];
        $cod_bod=$registros['COD_BOD'];


        $insertaplanilla="INSERT INTO ANDROID_TIT_CONSUMO_COMBUSTIBLE (COD_EMP,COD_TEM,PLANILLA,IDUSUARIO) values ('{$COD_EMP}','{$COD_TEM}','{$PLANILLA}','{$IDUSUARIO}')";
        $resultadoinserta=sqlsrv_query($conexion,$insertaplanilla);


        $consultaantes="SELECT llave FROM ANDROID_CONSUMO_COMBUSTIBLE WHERE llave='{$LLAVE}' ";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);

        if($registro=sqlsrv_fetch_array($resultadoantes)){
            $llave=$registro['llave'];
            if($llave==$LLAVE){
                $resulta["id"]='REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }else{
                $consulta="INSERT INTO ANDROID_CONSUMO_COMBUSTIBLE (COD_EMP, COD_TEM, PLANILLA, IDUSUARIO, FECHA, IDEMPRESA, IDTRABAJADOR, COD_MAQ, SUBITEM, CANTIDAD, ODOMETRO, HOROMETRO,LLAVE,VERSION,ZON,COD_BOD,TIPO_CARGA,FECHA_ACTUALIZACION,CANTIDAD_SALDO)        
                VALUES ('{$COD_EMP}','{$COD_TEM}','{$PLANILLA}','{$IDUSUARIO}','{$FECHA}','{$IDEMPRESA}','{$IDTRABAJADOR}','{$COD_MAQ}','{$SUBITEM}','{$CANTIDAD}','{$ODOMETRO}','{$HOROMETRO}','{$LLAVE}','{$VERSION}','{$idzona}','{$cod_bod}','{$TIPO_CARGA}','{$fechacambiada}','{$CANTIDAD_SALDO}')";
                
                
                $resultado=sqlsrv_query($conexion,$consulta);
                
                if($resultado){
                    $resulta["id"]='REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
                }
                else{
                    $resulta["id"]='NO REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
                }
                
            }
        }else{
            $consulta="INSERT INTO ANDROID_CONSUMO_COMBUSTIBLE (COD_EMP, COD_TEM, PLANILLA, IDUSUARIO, FECHA, IDEMPRESA, IDTRABAJADOR, COD_MAQ, SUBITEM, CANTIDAD, ODOMETRO, HOROMETRO,LLAVE,VERSION,ZON,COD_BOD,TIPO_CARGA,FECHA_ACTUALIZACION,CANTIDAD_SALDO)        
        VALUES ('{$COD_EMP}','{$COD_TEM}','{$PLANILLA}','{$IDUSUARIO}','{$FECHA}','{$IDEMPRESA}','{$IDTRABAJADOR}','{$COD_MAQ}','{$SUBITEM}','{$CANTIDAD}','{$ODOMETRO}','{$HOROMETRO}','{$LLAVE}','{$VERSION}','{$idzona}','{$cod_bod}','{$TIPO_CARGA}','{$fechacambiada}','{$CANTIDAD_SALDO}')";
       
		$resultado=sqlsrv_query($conexion,$consulta);
        
		 if($resultado){
            $resulta["id"]='REGISTRA';
            $json[]=$resulta;
            echo json_encode($json);
        }
        else{
            $resulta["id"]='NO REGISTRA';
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
	
?>


