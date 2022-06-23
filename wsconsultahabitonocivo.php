<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
if($conexion){
	$json=array();
	
    if(isset($_GET["IdEmpresa"])&&isset($_GET["IdHistoriaClinica"])){
        
        $IdEmpresa=$_GET["IdEmpresa"];
        $IdHistoriaClinica=$_GET["IdHistoriaClinica"];
       
        
		
		$consulta="SELECT isnull(hn.Idempresa,'') as 'Idempresa' ,isnull(hn.IdHistoriaClinica,'') as 'IdHistoriaClinica' ,isnull (hn.IdTipoHabitoNocivo,'') as 'IdTipoHabitoNocivo', 
        isnull(tn.Descripcion,'') as 'Descripcion',isnull(CONVERT(VARCHAR,hn.Fecha,23),'') as 'Fecha' ,isnull(hn.Escala,'') as 'Escala',isnull(hn.Frecuencia,'') as 'Frecuencia',
        isnull(hn.SW_NO_REFIERE,'') as 'SW_NO_REFIERE'
        FROM HabitoNocivo hn
        INNER JOIN TipoHabitoNocivo tn ON tn.IdEmpresa=hn.Idempresa and tn.IdTipoHabitoNocivo=hn.IdTipoHabitoNocivo
        WHERE hn.IdEmpresa='{$IdEmpresa}' and hn.IdHistoriaClinica='{$IdHistoriaClinica}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);	
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

     } else{
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