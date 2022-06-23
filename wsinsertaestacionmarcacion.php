<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["idempresa"])&&isset($_GET["Temporada"])
    &&isset($_GET["TIPO_ESTACION"])&&isset($_GET["NOMBRE_ESTACION"])
    &&isset($_GET["FECHA"])&&isset($_GET["TIPO"])){
        

        $idempresa=$_GET["idempresa"];
        $Temporada=$_GET["Temporada"];
        $TIPO_ESTACION=$_GET["TIPO_ESTACION"];
        $NOMBRE_ESTACION=$_GET["NOMBRE_ESTACION"];
        $FECHA=$_GET["FECHA"];
        $TIPO=$_GET["TIPO"];
              		 
		$consulta=" INSERT INTO Estacion_Marcacion(idempresa,Temporada,TIPO_ESTACION,NOMBRE_ESTACION,TIPO,FECHA) 
        VALUES('{$idempresa}','{$Temporada}','{$TIPO_ESTACION}','{$NOMBRE_ESTACION}','{$TIPO}','{$FECHA}')";
                	
		$resultado=sqlsrv_query($conexion,$consulta);
        
		 if($resultado){

           /*  $resulta["id"]='REGISTRA';
            $json[]=$resulta;
            echo json_encode($json); */
           $resulta["id"]='REGISTRA';
            $consulta_insert="SELECT ID FROM Estacion_Marcacion WHERE idempresa='{$idempresa}' AND Temporada='{$Temporada}' AND TIPO_ESTACION='{$TIPO_ESTACION}' AND NOMBRE_ESTACION='{$NOMBRE_ESTACION}' AND FECHA='{$FECHA}' AND TIPO='{$TIPO}' ";
            $resultado=sqlsrv_query($conexion,$consulta_insert);
         
            while($registro =sqlsrv_fetch_array($resultado)){
                $json[]=$registro;
            }
            echo json_encode($json); 
        }
        else{
            $resulta["id"]='NO REGISTRA';
            $json[]=$resulta;
            echo json_encode($json);
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

