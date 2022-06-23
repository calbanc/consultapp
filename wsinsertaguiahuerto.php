<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["SERIE"])&&isset($_GET["GUIA"])&&isset($_GET["CHOFER"])&&isset($_GET["PATENTE"])&&isset($_GET["FECHA"])){
        

        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $SERIE=$_GET["SERIE"];
        $GUIA=$_GET["GUIA"];
        $CHOFER=$_GET["CHOFER"];
        $PATENTE=$_GET["PATENTE"];
        $FECHA=$_GET["FECHA"];
      
        

        		
		$consulta="INSERT INTO GUIA_HUERTO (COD_EMP, COD_TEM, SERIE, GUIA, CHOFER, PATENTE,FECHA)        
        VALUES ('{$COD_EMP}','{$COD_TEM}','{$SERIE}','{$GUIA}','{$CHOFER}','{$PATENTE}','{$FECHA}')";
                	
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
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>

