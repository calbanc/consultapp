<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdContratista"])&&isset($_GET["IdEmpresa"])&&isset($_GET["IdTrabXContratista"])&&isset($_GET["Rut"])&&isset($_GET["Digito"])&&isset($_GET["Nombre"])&&isset($_GET["Activo"])&&isset($_GET["IdZona"])){
        $IdContratista=$_GET["IdContratista"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $IdTrabXContratista=$_GET["IdTrabXContratista"];
        $Rut=$_GET["Rut"];
        $Digito=$_GET["Digito"];
        $Nombre=$_GET["Nombre"];
        $Activo=$_GET["Activo"];
        $IdZona=$_GET["IdZona"];
		
		$consulta="INSERT INTO TrabajadorXContratista (IdContratista,IdEmpresa,IdTrabXContratista,Rut,Digito,Nombre,Activo,IdZona) VALUES('{$IdContratista}','{$IdEmpresa}','{$IdTrabXContratista}','{$Rut}','{$Digito}','{$Nombre}','{$Activo}','{$IdZona}')";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		if($resultado){
            $resulta["fecha"]='REGISTRADO CON EXITO';
            
        }else{
            $resulta["fecha"]='NO REGISTRADO';
        }

		
		echo json_encode($json);
		

	}else{
		$resultar["message"]='FALTAN DATOS';
		$json[]=$resultar;
		echo json_encode($json);
	}

	





}else{
	echo "CONEXION FALLIDA";
}
	
?>