<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	
		
        
		
		$consulta="SELECT DISTINCT(Nombre),idempresa  FROM zona where NOT nombre in ('ALAYO (OBREROS)','LA OBRILLA','GERENCIA GENERAL','JARDIN','CAMPOS EXTERNOS')and  idempresa in ('9','14')  and IdZona in('50','51','52','53','54','55','56','57','58','59','70','80','40')   order by Idempresa";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

	


}else{
	echo "CONEXION FALLIDA";
}
	
?>