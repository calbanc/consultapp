<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	


$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){      
	$json=array();
	if(isset($_GET["LLAVE"])&&isset($_GET["IDEMPRESA"])&&isset($_GET["FECHA"])&&isset($_GET["COD_TRP"])&&isset($_GET["COD_BUS"])
    &&isset($_GET["COD_TRONCAL"])&&isset($_GET["COD_RUTA"])&&isset($_GET["IDZONA"])&&isset($_GET["CANT_PERSONAS"])&&isset($_GET["OBSERVACION"])
    &&isset($_GET["IDCUARTEL"])&&isset($_GET["HORA"])){
        
        $LLAVE=$_GET["LLAVE"];
        $IDEMPRESA=$_GET["IDEMPRESA"];
        $FECHA=$_GET["FECHA"];
        $COD_TRP=$_GET["COD_TRP"];  
        $COD_BUS=$_GET["COD_BUS"];
        $COD_TRONCAL=$_GET["COD_TRONCAL"];
        $COD_RUTA=$_GET["COD_RUTA"];
        $IDZONA=$_GET["IDZONA"];
        $CANT_PERSONAS=$_GET["CANT_PERSONAS"];
        $OBSERVACION=$_GET["OBSERVACION"];
        $IDCUARTEL=$_GET["IDCUARTEL"];
        $HORA=$_GET["HORA"];
        
       

        $consultaantes="SELECT LLAVE FROM ANDROID_REGISTRO_RUTA WHERE LLAVE='{$LLAVE}'";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['LLAVE']==$LLAVE){
                $resulta["LLAVE"]=$LLAVE;
                    $json[]=$resulta;
                    echo json_encode($json);
            }
        }else{
            $insert="INSERT INTO ANDROID_REGISTRO_RUTA(LLAVE,IDEMPRESA,FECHA,COD_TRP,COD_BUS,COD_TRONCAL,COD_RUTA,IDZONA,CANT_PERSONAS,OBSERVACION,IDCUARTEL,HORA,IDUSUARIO,IdFamilia,IdActividad)
            VALUES('{$LLAVE}','{$IDEMPRESA}','{$FECHA}','{$COD_TRP}','{$COD_BUS}','{$COD_TRONCAL}','{$COD_RUTA}','{$IDZONA}','{$CANT_PERSONAS}','{$OBSERVACION}','{$IDCUARTEL}','{$HORA}','{$usuario}','111','15')";
           
            $resultado=sqlsrv_query($conexion,$insert);
            if($resultado){
                $resulta["LLAVE"]=$LLAVE;
                    $json[]=$resulta;
                    echo json_encode($json);
                }
                else{
                    $resulta["LLAVE"]='NO REGISTRA';
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