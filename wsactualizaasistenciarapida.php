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
	if(isset($_GET["Correlativo"])&&isset($_GET["cantidad"])&&isset($_GET["IdFamilia"])&&isset($_GET["IdLabor"])&&isset($_GET["Etapa"])){
        
        $Correlativo=$_GET["Correlativo"];
        $cantidad=$_GET["cantidad"];
        $IdFamilia=$_GET["IdFamilia"];
        $IdLabor=$_GET["IdLabor"];
        $Etapa=$_GET["Etapa"];
        $hora=$_GET["hora"];
        
       
       
       	
		$consulta="UPDATE AsistenciaRapida SET Cantidad='{$cantidad}', IdFamilia='{$IdFamilia}' ,IdActividad='{$IdLabor}' ,Etapa='{$Etapa }' WHERE Correlativo='{$Correlativo}' and  Sw_App='1' and SW_Aprobado='0' " ;

       
        
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