<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])){
       
        $IdEmpresa=$_GET["IdEmpresa"];
		
		$consulta=" SELECT c.IdEmpresa,c.IdCuadrilla,c.IdTrabajador_Enc,tr.ApellidoPaterno,tr.ApellidoMaterno,tr.Nombre
		FROM [bsis_rem_afr].[dbo].[Cuadrilla] c
		inner join Contratos t on t.IdTrabajador=c.IdTrabajador_Enc and t.IdEmpresa=c.IdEmpresa
		inner join Trabajador tr on tr.IdTrabajador=c.IdTrabajador_Enc and tr.IdEmpresa=c.IdEmpresa
		where c.IdEmpresa='{$IdEmpresa}' and t.IndicadorVigencia='1' ";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

	





}else{
	echo "CONEXION FALLIDA";
}
	
?>
