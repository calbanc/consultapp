
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
            $consulta="SELECT IDTEMPORADA AS 'COD_TEM', DESCRIPCION FROM  BSIS_REM_AFR.DBO.TEMPORADA WHERE IDEMPRESA='{$COD_EMP}' ";
        }else{
            $consulta="SELECT COD_TEM,DESCRIPCION FROM TEMPORADAS where COD_EMP='{$COD_EMP}'  ORDER BY DESCRIPCION DESC";
        }
		
		
		
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
		
		$consulta="SELECT COD_TEM,DESCRIPCION FROM TEMPORADAS where COD_EMP='{$COD_EMP}'  ORDER BY DESCRIPCION DESC";
		
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