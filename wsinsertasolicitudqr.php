<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["IdTrabajador"])
    &&isset($_GET["RutTrabajador"])
    &&isset($_GET["IdEmpresaTrabajador"])
    &&isset($_GET["Solicitante"])
    &&isset($_GET["Glosa"])
    &&isset($_GET["NombreTrabajador"])
    &&isset($_GET["Columnas"])
    &&isset($_GET["Cantidad"])
    &&isset($_GET["Llave"])
    &&isset($_GET["Fecha"])){
        

        $IdTrabajador=$_GET["IdTrabajador"];
        $RutTrabajador=$_GET["RutTrabajador"];
        $IdEmpresaTrabajador=$_GET["IdEmpresaTrabajador"];
        $Solicitante=$_GET["Solicitante"];
        $Glosa=$_GET["Glosa"];
        $NombreTrabajador=$_GET["NombreTrabajador"];
        $Columnas=$_GET["Columnas"];
        $Cantidad=$_GET["Cantidad"];
        $Llave=$_GET["Llave"];
        $Fecha=$_GET["Fecha"];
        

        		
		$consulta="INSERT INTO Solicitud_Qr(IdTrabajador,RutTrabajador,IdEmpresaTrabajador,Solicitante,Glosa,NombreTrabajador,Columnas,Cantidad,Llave,Fecha)
         VALUES ('{$IdTrabajador}','{$RutTrabajador}','{$IdEmpresaTrabajador}','{$Solicitante}','{$Glosa}','{$NombreTrabajador}','{$Columnas}','{$Cantidad}','{$Llave}','{$Fecha}')";
                	
		$resultado=sqlsrv_query($conexion,$consulta);
        
		 if($resultado){
             $data=array(
                 'id'=>'REGISTRA'
             ); 
             $json[]=$data;
             echo json_encode($json);
                        
                }
                else{
					$data=array(
                        'id'=>'NO REGISTRA'
                    );
                    $json[]=$data;
                    echo json_encode($json);
                }
                
		

	}else{
		$resultar["Datos"]='Faltan datos';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>







