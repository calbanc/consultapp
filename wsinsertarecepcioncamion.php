<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["TIPO_CAMION"])
    &&isset($_GET["COD_TIP_CON"]) 
    &&isset($_GET["Fecha_ingreso"])
    &&isset($_GET["RutConductor"])
    &&isset($_GET["NombreConductor"])
    &&isset($_GET["EmpresaTransporte"])
    &&isset($_GET["Patente"])
    &&isset($_GET["Guia_ingreso"])
    &&isset($_GET["Carga"])
    &&isset($_GET["Motivo"])
    &&isset($_GET["Telefono"])
    &&isset($_GET["Contenedor"])
    &&isset($_GET["NSERIE"])
    &&isset($_GET["Temperatura"])
    &&isset($_GET["Observacion"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $Fecha_ingreso=$_GET["Fecha_ingreso"];
        $RutConductor=$_GET["RutConductor"];
        $NombreConductor=$_GET["NombreConductor"];
        $EmpresaTransporte=$_GET["EmpresaTransporte"];
        $Patente=$_GET["Patente"];
        $Guia_ingreso=$_GET["Guia_ingreso"];
        $Carga=$_GET["Carga"];
        $Motivo=$_GET["Motivo"];
        $Telefono=$_GET["Telefono"];
        $Observacion=$_GET["Observacion"];
        $Contenedor=$_GET["Contenedor"];
        $TIPO_CAMION=$_GET["TIPO_CAMION"];
        $COD_TIP_CON=$_GET["COD_TIP_CON"];
        $Nserie=$_GET["NSERIE"];
        $Temperatura=$_GET["Temperatura"];


        if(is_numeric($COD_EMP)&&$COD_EMP<>'9'){
            $consultaempresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='{$COD_EMP}'";
            $resultadoempresa=sqlsrv_query($conexion,$consultaempresa);
            if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
                $NUEVAEMPRESA=$registroempresa['COD_EMP'];
            }
        }else{
            if($COD_EMP=='9'){
                $NUEVAEMPRESA='ARAP';
            }
            
        }

        $COD_EMP=$NUEVAEMPRESA;
        $consulta1="SELECT ZON FROM PACKINGS_PARAMETROS WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$usuario}' ";
        
       
        $resultado2=sqlsrv_query($conexion,$consulta1);
        $registros=sqlsrv_fetch_array($resultado2);
        $idzona=$registros['ZON'];

        $emrps=explode("-",$EmpresaTransporte);
        $cod_trp=$emrps[0];
        $RutConductor=str_replace('.','',$RutConductor);


        $consultaantes="SELECT * FROM ANDROID_RECEPCION_CAMIONES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'  AND CONVERT(date,Fecha_ingreso,103)='{$Fecha_ingreso}'  AND Patente='{$Patente}' and Fecha_salida is NULL " ;
       
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registross=sqlsrv_fetch_array($resultadoantes)){
            $patenteantes=$registross['Patente'];    
            if($patenteantes==$Patente){
                $data=array(
                    'id'=>'ANTES'
                );
                $json[]=$data;
                echo json_encode($json);
            }else{
               
            
            }			
        }else{
            $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,EmpresaTransporte,Patente,Guia_ingreso,Carga,Motivo,Telefono,Observacion,Contenedor,UsuarioSis_ingreso,Sw_Despachado,ZON,COD_TRP,TIPO_CAMION,COD_TIP_CON,nserie,TIPO,temperatura)
                    VALUES('{$COD_EMP}','{$COD_TEM}','{$Fecha_ingreso}','{$RutConductor}','{$NombreConductor}','{$EmpresaTransporte}','{$Patente}','{$Guia_ingreso}','{$Carga}','{$Motivo}','{$Telefono}','{$Observacion}','{$Contenedor}','{$usuario}','0','{$idzona}','{$cod_trp}','{$TIPO_CAMION}','{$COD_TIP_CON}','{$Nserie}','CAMION','{$Temperatura}')";
                    
                    $resultado=sqlsrv_query($conexion,$consulta);

                    if($resultado){
                        $data=array(
                            'id'=>'REGISTRADO'
                        );
                        $json[]=$data;
                        echo json_encode($json);
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