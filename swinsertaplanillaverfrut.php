<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

    $usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
         
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdTrabajador"])&&isset($_GET["IdActividad"])&&isset($_GET["IdFamilia"])&&isset($_GET["IdEmpresa"])&&isset($_GET["Temporada"])&&isset($_GET["IdCuartel"])&&
    isset($_GET["IdZona"])&&isset($_GET["FechaActividad"])&&isset($_GET["HoraInicio"])&&isset($_GET["HoraFinal"])&&isset($_GET["UnidadProducida"])&&
    isset($_GET["IdCuadrilla"])&&isset($_GET["Ciclo"])&&isset($_GET["PLANILLA"])&&isset($_GET["USUARIO"])&&isset($_GET["COD_BUS"])&&isset($_GET["ValorReferencia"])&&
    isset($_GET["POR_TAREA"])&&isset($_GET["VERSIONAPP"])&&isset($_GET["IDPLANILLAANDROID"])&&isset($_GET["SW_IMPORTADO"])&&isset($_GET["ETAPA"])&&isset($_GET["IdEmpresaTrabajador"])
    &&isset($_GET["LECTURA"])&&isset($_GET["CREATED_UP"])&&isset($_GET["Llave"])&&isset($_GET["refrigerio"])&&isset($_GET["observacion"])){
        

        $IdTrabajador=$_GET["IdTrabajador"];
        $IdActividad=$_GET["IdActividad"];
        $IdFamilia=$_GET["IdFamilia"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $IdCuartel=$_GET["IdCuartel"];
        $IdZona=$_GET["IdZona"];
        $FechaActividad=$_GET["FechaActividad"];
        $HoraInicio=$_GET["HoraInicio"];
        $HoraFinal=$_GET["HoraFinal"];
        $UnidadProducida=$_GET["UnidadProducida"];
        $IdCuadrilla=$_GET["IdCuadrilla"];
        $Ciclo=$_GET["Ciclo"];
        $PLANILLA=$_GET["PLANILLA"];
        $USUARIO=$_GET["USUARIO"];
        $COD_BUS=$_GET["COD_BUS"];
        $ValorReferencia=$_GET["ValorReferencia"];
        $POR_TAREA=$_GET["POR_TAREA"];
		$ETAPA=$_GET["ETAPA"];
        $LECTURA=$_GET["LECTURA"];
        $IdEmpresaTrabajador=$_GET["IdEmpresaTrabajador"];
        $VERSIONAPP=$_GET["VERSIONAPP"];
        $IDPLANILLAANDROID=$_GET["IDPLANILLAANDROID"];
        $SW_IMPORTADO=$_GET["SW_IMPORTADO"];
        $CREATED_UP=$_GET["CREATED_UP"];
        $Llave=$_GET["Llave"];
        $refrigerio=$_GET["refrigerio"];
        $observacion=$_GET["observacion"];


        $Llave.=$IdEmpresaTrabajador;
        $Llave.=$Temporada;
     
        $consultaantes="SELECT Llave FROM ActividadTrabajadorAndroid WHERE Llave='{$Llave}' and IdEmpresa='{$IdEmpresa}' and Temporada='{$Temporada}' ";

        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
      
        if($registross=sqlsrv_fetch_array($resultadoantes)){

            if($registross['Llave']==$Llave){
                $data=array('id'=>'REGISTRA'); 
                $json[]=$data;
                echo json_encode($json);
            }else{        
                $data=array('id'=>'NO REGISTRA'); 
                $json[]=$data;
                echo json_encode($json);
                             
            }
            }else{
                $consulta="INSERT INTO ActividadTrabajadorAndroid(Llave,IdTrabajador,IdActividad,IdFamilia,IdEmpresa,Temporada,IdCuartel,IdZona,FechaActividad,HoraInicio,HoraFinal,
                    UnidadProducida,IdCuadrilla,Ciclo,PLANILLA,USUARIO,COD_BUS,ETAPA,ValorReferencia,POR_TAREA,VERSIONAPP,IDPLANILLAANDROID,SW_IMPORTADO,IdEmpresaTrabajador,LECTURA,CREATED_UP,OBSERVACION_ANDROID,REFRIGERIO) VALUES ('{$Llave}','{$IdTrabajador}','{$IdActividad}',
                    '{$IdFamilia}','{$IdEmpresa}','{$Temporada}','{$IdCuartel}','{$IdZona}','{$FechaActividad}','{$HoraInicio}','{$HoraFinal}','{$UnidadProducida}','{$IdCuadrilla}','{$Ciclo}','{$PLANILLA}',
                    '{$USUARIO}','{$COD_BUS}','{$ETAPA}','{$ValorReferencia}','{$POR_TAREA}','{$VERSIONAPP}','{$PLANILLA}','{$SW_IMPORTADO}','{$IdEmpresaTrabajador}','{$LECTURA}','{$CREATED_UP}','{$observacion}','{$refrigerio}')";
                                
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
           
             }
          
       
        
		

	}else{
		$resultar["id"]='Faltan datos';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
}
else{
	$resultar["message"]='Sin usuario';
	$json[]=$resultar;
	echo json_encode($json);
} 

	
?>







