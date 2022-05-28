
<!-- 
<?PHP
//$hostname_localhost="192.168.60.8";

$hostname_localhost="VFPAPP01\SQLEXPRESS";

$info=array("Database"=>"PRUEBAS","UID"=>"sa","PWD"=>"123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDEMPRESA"])&&isset($_GET["IDTEMPORADA"])&&isset($_GET["IDREGISTRO"])&&isset($_GET["IDPLANILLA"])&&isset($_GET["USUARIO"])&&isset($_GET["FECHA"])&&
    isset($_GET["HORA"])){
        

        $IDEMPRESA=$_GET["IDEMPRESA"];
        $IDTEMPORADA=$_GET["IDTEMPORADA"];
        $IDREGISTRO=$_GET["IDREGISTRO"];
        $IDPLANILLA=$_GET["IDPLANILLA"];
        $USUARIO=$_GET["USUARIO"];
        $FECHA=$_GET["FECHA"];
        $HORA=$_GET["HORA"];    
        
        
		
            $consulta="INSERT INTO TIT_DATOS(IDEMPRESA,IDTEMPORADA,IDREGISTRO,IDPLANILLA,USUARIO,FECHA,HORA)
            VALUES('{$IDEMPRESA}','{$IDTEMPORADA}','{$IDPLANILLA}','{$IDREGISTRO}','{$IDPLANILLA}','{$USUARIO}','{$FECHA}','{$HORA}')";
            
                   
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
	
?> -->
