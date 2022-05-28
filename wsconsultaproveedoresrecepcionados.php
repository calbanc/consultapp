<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        
        $sqlwhere="";
        $consultazona="SELECT IdZona from [BPRIV].[dbo].[ZONAS_USUARIOS] where IdAplicacion='AppMt' and IdUsuario='{$usuario}' and IdEmpresa='{$COD_EMP}'";

        $resultadozona=sqlsrv_query($conexion,$consultazona);
        if($registross=sqlsrv_fetch_array($resultadozona)){
            $ZON=$registross['IdZona'];
        }
		if($ZON==''){
				
		}else{
			$sqlwhere.=" AND TIT.ZON='{$ZON}'";
		}


		$consulta="SELECT DISTINCT TIT.CODIGOCLIENTE AS 'SUBITEM' ,PRO.NombreCliente AS 'DES_SITEM' 
        FROM TIT_RECEPCIONMATERIALES TIT
        INNER JOIN PROVEEDORES PRO ON PRO.COD_EMP=TIT.COD_EMP AND PRO.COD_TEM=TIT.COD_TEM AND PRO.CODIGOCLIENTE=TIT.CODIGOCLIENTE
        WHERE TIT.COD_EMP='{$COD_EMP}' AND TIT.COD_TEM='{$COD_TEM}' ".$sqlwhere."
        ORDER BY PRO.NombreCliente ";
	
		

        
		
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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 	
?>      