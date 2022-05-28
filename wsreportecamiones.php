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
    &&isset($_GET["Fecha_ingreso"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $Fecha_ingreso=$_GET["Fecha_ingreso"];
        
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

        $consulta1="SELECT ZON FROM PACKINGS_PARAMETROS WHERE COD_EMP=? AND COD_TEM=? AND IDUSUARIO=? ";
        $parametros1=array($COD_EMP,$COD_TEM,$usuario);
       
        $resultado2=sqlsrv_query($conexion,$consulta1,$parametros1);
        $registros=sqlsrv_fetch_array($resultado2);
        $idzona=$registros['ZON'];

        $emrps=explode("-",$EmpresaTransporte);
        $cod_trp=$emrps[0];
        $RutConductor=str_replace('.','',$RutConductor);


        $consultaantes="SELECT CONVERT(varchar,Fecha_ingreso,103) AS 'FECHA_INGRESO',CONVERT(varchar,Fecha_ingreso,108) AS 'HORA_INGRESO',
               ISNULL(CONVERT(varchar,Fecha_salida,108),'') AS 'HORA_SALIDA',RutConductor,NombreConductor,ISNULL(EmpresaTransporte,'') AS 'EmpresaTransporte' ,Patente,
               ISNULL(Guia_ingreso,'') as 'Guia_ingreso',ISNULL(Guia_salida,'')as 'Guia_salida',ISNULL(Carga,'')as 'Carga',ISNULL(Motivo,'')as 'Motivo',ISNULL(Observacion,'')as'Observacion',ISNULL(Telefono,'') as 'Telefono',
               ISNULL(TIPO,'') AS 'TipoIngreso',ISNULL(temperatura,'') as 'Temperatura'
               FROM ANDROID_RECEPCION_CAMIONES  
               WHERE COD_EMP=? AND COD_TEM=? AND CONVERT(date,Fecha_ingreso,103)=? AND  UsuarioSis_ingreso=? ";
        $parametros=array($COD_EMP,$COD_TEM,$Fecha_ingreso,$usuario);
        $resultadoantes=sqlsrv_query($conexion,$consultaantes,$parametros);
        
        while($registross=sqlsrv_fetch_array($resultadoantes)){
            $json[]=$registross;
          
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 
	
?>