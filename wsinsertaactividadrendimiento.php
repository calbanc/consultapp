<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdTrabajador"])&&isset($_GET["IdActividad"])&&isset($_GET["IdFamilia"])&&isset($_GET["IdEmpresa"])&&isset($_GET["Temporada"])
    &&isset($_GET["IdCuartel"])&&isset($_GET["IdZona"])&&isset($_GET["FechaActividad"])&&isset($_GET["UnidadProducida"])&&isset($_GET["Hora"])
    &&isset($_GET["IdEmpresaTrabajador"])&&isset($_GET["Llave"])&&isset($_GET["COD_LINEA"])){
        

        $IdTrabajador=$_GET["IdTrabajador"];
        $IdEmpresaTrabajador=$_GET["IdEmpresaTrabajador"];
        $IdActividad=$_GET["IdActividad"];
        $IdFamilia=$_GET["IdFamilia"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $IdCuartel=$_GET["IdCuartel"];
        $IdZona=$_GET["IdZona"];
        $FechaActividad=$_GET["FechaActividad"];
        $UnidadProducida=$_GET["UnidadProducida"];
        $Llave=$_GET["Llave"];
        $COD_LINEA=$_GET["COD_LINEA"];
        $HORA=$_GET["Hora"];

        $consultaantes="SELECT Llave FROM Rendimientos WHERE Llave='{$Llave}' ";
        $resultadoantes=sqlsrv_query($conexion,$consulta);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            if($registross['Llave']==$Llave){
                $data=array('id'=>$Llave); 
                $json[]=$data;
                echo json_encode($json);
            
            }else{
                $data=array('id'=>$Llave); 
                $json[]=$data;
                echo json_encode($json);
            }
        
        }else{
            $consulta="INSERT INTO Rendimientos(IdActividadTrabajador,IdTrabajador,IdEmpresaTrabajador,IdActividad,IdFamilia,IdEmpresa,Temporada,
            IdCuartel,IdZona,FechaActividad,Hora,UnidadProducidad,USUARIO,cod_linea) 
            VALUES ('{$IdActividadTrabajador}','{$IdTrabajador}','{$IdEmpresaTrabajador}','{$IdActividad}','{$IdFamilia}','{$IdEmpresa}','{$Temporada}',
            '{$IdCuartel}','{$IdZona}','{$FechaActividad}','{$Hora}','{$UnidadProducidad}','{$USUARIO}','{$cod_linea}')";
                        
            $resultado=sqlsrv_query($conexion,$consulta);
            
             if($resultado){
                $data=array('id'=>$Llave); 
                $json[]=$data;
                echo json_encode($json);
                            
            }else{
                $data=array('id'=>'NO REGISTRA'); 
                $json[]=$data;
                echo json_encode($json);
            }
                    
        }
        

        		
		
		

	}else{
		$resultar["id"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>




