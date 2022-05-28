<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["idempresa"])&&isset($_GET["ruttrbajador"])&&isset($_GET["codigotrabajador"])&&isset($_GET["trabajador"])&&isset($_GET["zona"])&&isset($_GET["fecha"])&&
    isset($_GET["hora"])&&isset($_GET["epp"])&&isset($_GET["usuario"])){
        

        $idempresa=$_GET["idempresa"];
        $ruttrbajador=$_GET["ruttrbajador"];
        $codigotrabajador=$_GET["codigotrabajador"];
        $trabajador=$_GET["trabajador"];
        $zona=$_GET["zona"];
        $fecha=$_GET["fecha"];
        $hora=$_GET["hora"];    
        $epp=$_GET["epp"];
        $usuario=$_GET["usuario"];
        

        		
		$consulta="INSERT INTO ReposicionCovid(idempresa,ruttrbajador,codigotrabajador,trabajador,zona,fecha,hora,epp,usuario) VALUES ('{$idempresa}','{$ruttrbajador}',
        '{$codigotrabajador}','{$trabajador}','{$zona}','{$fecha}','{$hora}','{$epp}','{$usuario}')";
                	
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



