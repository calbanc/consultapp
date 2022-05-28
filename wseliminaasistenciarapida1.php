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
	if(isset($_GET["Correlativo"])){
        
        $Correlativo=$_GET["Correlativo"];
       
        
        $id=explode("-",$Correlativo);
        $correlacion=$id[0];
        $IdEmpresa=$id[1];
        $IdZona=$id[2];
        $año=$id[3];
        $mes=$id[4];
       
       	
		$consulta="DELETE FROM ANDROID_AsistenciaRapida WHERE Llave='{$Correlativo}' AND SW_Aprobado ='0' " ;

       

		$resultado=sqlsrv_query($conexion,$consulta);
       
		
		if($resultado){
            $resulta["id"]=$Correlativo;
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