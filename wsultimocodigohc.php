<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){
	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	$info=array("Database"=>"bsis_rem_afr","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&& isset($_GET["IdTipoHistoriaClinica"])){
        $COD_EMP=$_GET["COD_EMP"];
        $IdTipoHistoriaClinica=$_GET["IdTipoHistoriaClinica"];
       
		$consulta="SELECT CODIGO=ISNULL(MAX(IdHistoriaClinica),1) FROM HistoriaClinica WITH(NOLOCK) WHERE IdTipoHistoriaClinica = '{$IdTipoHistoriaClinica}' and  IdEmpresa = '{$COD_EMP}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
        if($registross=sqlsrv_fetch_array($resultado)){
                      
            $json[]=$registross;
            echo json_encode($json); 
        }
	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	$resultar["CONEXION"]='CONEXION';
	$json[]=$resultar;
	echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
?>