<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	$info=array("Database"=>"erpfrusys","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])){
        $COD_EMP=$_GET["COD_EMP"];

        if(is_numeric($COD_EMP)){
            $consulta="SELECT IDEMPRESA  AS 'ID_EMPRESA_REM' FROM  BSIS_REM_AFR.DBO.EMPRESA WHERE IDEMPRESA='{$COD_EMP}' ";
        }else{
            $consulta="SELECT ID_EMPRESA_REM FROM EMPRESAS where COD_EMP='{$COD_EMP}'";
        }
       
		
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		if($registros=sqlsrv_fetch_array($resultado)){
		
			$version=$registros['ID_EMPRESA_REM'];
			$data=array('ID_EMPRESA_REM'=>$version); 
                        $json[]=$data;
                        echo json_encode($json);
		}
		

		
		echo json_encode($json);
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

	





}else{
	$version='CONEXION';
			$data=array('ID_EMPRESA_REM'=>$version); 
                        $json[]=$data;
                        echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
?>