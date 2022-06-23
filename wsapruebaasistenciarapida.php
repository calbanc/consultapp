<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])&&isset($_GET["FechaActividad"])&&isset($_GET["IdZona"])&&isset($_GET["IdCuartel"])&&isset($_GET["hora"])){
        
        $IdEmpresa=$_GET["IdEmpresa"];
        $FechaActividad=$_GET["FechaActividad"];
        $IdZona=$_GET["IdZona"];
        $hora=$_GET["hora"];
        $IdCuartel=$_GET["IdCuartel"];

        $sqlwhere="";


        if($IdZona=='55'){
            $sqlwhere.=" AND IdCuartel='{$IdCuartel}' ";
        }
        
       	
		$consulta="UPDATE AsistenciaRapida SET SW_Aprobado='1', FechaAprobacion='{$hora}' WHERE IdEmpresa='{$IdEmpresa}' 
        AND  Sw_App='1' AND FechaActividad='{$FechaActividad}' AND IdZona='{$IdZona}' ".$sqlwhere ;
    
       

		$resultado=sqlsrv_query($conexion,$consulta);
       
		
		if($resultado){
            $resulta["id"]='REGISTRA';
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 	
?>