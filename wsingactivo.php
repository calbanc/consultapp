<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
		$COD_PAIS="";
        $WHERE="";
        if($COD_EMP=="TODOS"){
            $consultaempresa="SELECT COD_PAIS FROM EMPRESAS WHERE COD_EMP='ARAP' ";
            
        }else{
            $where="AND S.COD_EMP='{$COD_EMP}' ";
        }


        

			
		$execempresa=sqlsrv_query($conexion,$consultaempresa);
		if($resultadoempresa=sqlsrv_fetch_array($execempresa)){
			$COD_PAIS=$resultadoempresa['COD_PAIS'];	
            $WHERE="AND E.COD_PAIS='{$COD_PAIS}'";
		}
        
        
		$consulta=" SELECT distinct S.ING_ACTIVO 
        from SUBITEM S
        INNER JOIN EMPRESAS E ON E.COD_EMP=S.COD_EMP
        where  S.COD_TEM='{$COD_TEM}'" .$where;
		echo $consulta;
		die();
		
	
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro=sqlsrv_fetch_array($resultado)){
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