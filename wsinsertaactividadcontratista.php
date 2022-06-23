<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])&&isset($_GET["IdTrabajador"])&&isset($_GET["IdActividad"])&&isset($_GET["IdFamilia"])&&isset($_GET["IdCuartel"])&&isset($_GET["IdZona"])&&isset($_GET["FechaActividad"])&&isset($_GET["HoraInicio"])&&isset($_GET["HoraFinal"])&&isset($_GET["ValorReferencia"])&&isset($_GET["Temporada"])&&isset($_GET["IdContratista"])&&isset($_GET["Ciclo"])&&isset($_GET["IdTrabajador_Enc"])&&isset($_GET["UnidadProducida"])){
        $IdEmpresa=$_GET["IdEmpresa"];
        $IdTrabajador=$_GET["IdTrabajador"];
        $IdActividad=$_GET["IdActividad"];
        $IdFamilia=$_GET["IdFamilia"];
        $IdCuartel=$_GET["IdCuartel"];
        $IdZona=$_GET["IdZona"];
        $FechaActividad=$_GET["FechaActividad"];
        $HoraInicio=$_GET["HoraInicio"];
        $HoraFinal=$_GET["HoraFinal"];
        $ValorReferencia=$_GET["ValorReferencia"];
        $Temporada=$_GET["Temporada"];
        $IdContratista=$_GET["IdContratista"];
        $Ciclo=$_GET["Ciclo"];
        $IdTrabajador_Enc=$_GET["IdTrabajador_Enc"];
        $UnidadProducida=$_GET["UnidadProducida"];
        
        

        
		
		$consulta="INSERT INTO ActividadContratista_Android (IdTrabajador,IdActividad,IdFamilia,IdEmpresa,IdCuartel,IdZona,FechaActividad,HoraInicio,HoraFinal,ValorReferencia,Temporada,IdContratista,Ciclo,IdTrabajador_Enc,UnidadProducida) VALUES('{$IdTrabajador}','{$IdActividad}','{$IdFamilia}','{$IdEmpresa}','{$IdCuartel}','{$IdZona}','{$FechaActividad}','{$HoraInicio}','{$HoraFinal}','{$ValorReferencia}','{$Temporada}','{$IdContratista}','{$Ciclo}','{$IdTrabajador_Enc}','{$UnidadProducida}')";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		if($resultado){
            $resulta["fecha"]='REGISTRADO';
        }else{
            $resulta["fecha"]='NO REGISTRADO';
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

