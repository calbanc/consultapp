<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
if($conexion){
	$json=array();
	
    if(isset($_GET["FECHA"])){
        
        $FECHA=$_GET["FECHA"];
       
        
		
		$consulta="SELECT COUNT(DISTINCT(RutTrabajador)) as 'CantidadMarcacion',em.NOMBRE_ESTACION,ISNULL( MAX(rt.Pasajeros),'') as 'Reporte_Chofer',CONVERT(VARCHAR,ma.Fecha,105) AS 'Fecha'
		From  [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Marcacion_Android ma
		INNER JOIN [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Estacion_Marcacion_Prueba em ON em.ID=ma.IdEstacion
		LEFT JOIN [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Reporte_Transporte rt ON rt.IdEstacion=ma.IdEstacion and rt.Fecha=ma.Fecha	
		where ma.Fecha='{$FECHA}' group by ma.Fecha,em.NOMBRE_ESTACION";
		
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