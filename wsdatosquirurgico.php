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
       
        
		
		$consulta="SELECT Q.IdEmpresa,Q.IdHistoriaClinica,Q.IdTipoCirugia,TC.Descripcion,isnull(CONVERT(VARCHAR,Q.Fecha,23),'') as 'Fecha',isnull(Q.Resultados,'') as 'Resultados',
        isnull(Q.SW_NO_REFIERE,'') as 'SW_NO_REFIERE'
        FROM Quirurgico Q 
        INNER JOIN TipoCirugia TC ON TC.IdEmpresa=Q.IdEmpresa AND TC.IdTipoCirugia=Q.IdTipoCirugia
        WHERE Q.IdEmpresa='{$IdEmpresa}' and Q.IdHistoriaClinica='{$IdHistoriaClinica}'";
        
		
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