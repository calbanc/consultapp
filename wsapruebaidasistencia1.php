<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["Correlativo"])&&isset($_GET["hora"])&isset($_GET["IdEmpresa"])){
        
        $Llave=$_GET["Correlativo"];
       
        $hora=$_GET["hora"];
        $IdEmpresa=$_GET["IdEmpresa"];
        
       
        $consultaregistro="SELECT  *,convert(varchar,FechaActividad,103) as 'fecha'from ANDROID_AsistenciaRapida WHERE IdEmpresa='{$IdEmpresa}' and Llave='{$Llave}' and Fecha_Aprobacion is null";
        
   
        $execcosnultaregistro=sqlsrv_query($conexion,$consultaregistro);

        if($registro=sqlsrv_fetch_array($execcosnultaregistro,SQLSRV_FETCH_ASSOC)){
            $empresa=$registro['IdEmpresa'];
            $fecha=$registro['fecha'];
            $zona=$registro['IdZona'];
            $cuartel=$registro['IdCuartel'];
            $tipotrabajador=$registro['TipoTrabajador'];
            $turno=$registro['Turno'];
            $actividad=$registro['IdActividad'];
            $familia=$registro['IdFamilia'];
            $etapa=$registro['ETAPA'];
            $año=$registro['Año'];
            $mes=$registro['Mes'];
            $cantidadtrabajadores=$registro['Cantidad'];
            $dt = new DateTime("now", $dtz);
            $fecharegistro = $dt->format("Y-m-d") . "T" . $dt->format("H:i:s");
    
       

            $consultaproduccion="SELECT Cantidad,Correlativo 
            FROM AsistenciaRapida
            where IdEmpresa='{$empresa}' and  FechaActividad='{$fecha}' 
            and IdCuartel='{$cuartel}' and Turno='{$turno}' and  IdFamilia='{$familia}' and IdActividad='{$actividad}' and Etapa='{$etapa}' and TipoTrabajador='{$tipotrabajador}'  ";
      
            $resultadoregistro=sqlsrv_query($conexion,$consultaproduccion);
            if($registroasistencia=sqlsrv_fetch_array($resultadoregistro)){

                $cantidad=$registroasistencia['Cantidad'];
                $correlativoasistencia=$registroasistencia['Correlativo'];
                $nuevacantidad=$cantidadtrabajadores+$cantidad;
                $updateasistencia="UPDATE AsistenciaRapida set Cantidad='{$nuevacantidad}' where Correlativo='{$correlativoasistencia}' and IdEmpresa='{$empresa}' ";     
                     
                $execactualiza=sqlsrv_query($conexion,$updateasistencia);
                $resultadoactualiza=sqlsrv_rows_affected($execactualiza);

                $updateandroid="UPDATE ANDROID_AsistenciaRapida  set SW_APROBADO='1' , Fecha_Aprobacion='{$fecharegistro}',SW_IMPORTADO='1', CORRELATIVO='{$correlativoasistencia}'   where IdEmpresa='{$empresa}' and Llave='{$Llave}' ";
             
                    
                    
                $execactualizaandroid=sqlsrv_query($conexion,$updateandroid);
                if($resultadoactualiza>=1){
                    $resulta["id"]=$Llave;
                    $json[]=$resulta;
                    echo json_encode($json);
                }
                
            }else{
                $consultamax="SELECT ISNULL(MAX (Correlativo),0) +1 AS 'Id' FROM AsistenciaRapida where IdEmpresa='{$IdEmpresa}'";

                $resultadomax=sqlsrv_query($conexion,$consultamax);
                 if($registromax=sqlsrv_fetch_array($resultadomax)){
                    $nuevocorrelativo=$registromax['Id'];
                     $insert="INSERT INTO AsistenciaRapida(IdEmpresa,Año,Mes,IdZona,Correlativo,IdFamilia,IdActividad,Cantidad,FechaActividad,IdCuartel,TipoTrabajador,Turno,ETAPA,FechaRegistro,Sw_App) 
                              VALUES('{$empresa}','{$año}','{$mes}','{$zona}','{$nuevocorrelativo}','{$familia}','{$actividad}','{$cantidadtrabajadores}','{$fecha}','{$cuartel}','{$tipotrabajador}','{$turno}','{$etapa}','{$fecharegistro}','1')";
                   
                    $execinsert=sqlsrv_query($conexion,$insert);
       
                    $updateandroid="UPDATE ANDROID_AsistenciaRapida  set SW_APROBADO='1' , Fecha_Aprobacion='{$fecharegistro}',SW_IMPORTADO='1', CORRELATIVO='{$nuevocorrelativo}'   where IdEmpresa='{$empresa}' and Llave='{$Llave}' ";
                   
                    
                    
                    $execactualizaandroid=sqlsrv_query($conexion,$updateandroid);
                    $resultadoexecactualizaandroid=sqlsrv_rows_affected($execactualizaandroid);
                          if($resultadoexecactualizaandroid>=1){
                            $resulta["id"]=$Llave;
                                $json[]=$resulta;
                                echo json_encode($json);
                          }
                
                 }
            }
            
        }
   
		
       
		
		


	}else{
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