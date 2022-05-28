<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
	
	$info=array("Database"=>"bsis_rem_afr","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $consulta="";
       
        if($COD_EMP=='9'||$COD_EMP=='14'){
            
            $consulta="SELECT R.IDEMPRESA,R.COD_RUTA,R.DESCRIPCION AS 'RUTA' , R.COD_TRONCAL,T.DESCRIPCION AS 'TRONCAL'
            FROM RUTAS R 
            INNER JOIN TRONCAL T ON R.IDEMPRESA=T.IDEMPRESA AND R.COD_TRONCAL=T.COD_TRONCAL
            WHERE R.IDEMPRESA='9' OR R.IDEMPRESA='14'";
          

            
        }else{
            
            $consulta="SELECT R.IDEMPRESA,R.COD_RUTA,R.DESCRIPCION AS 'RUTA' , R.COD_TRONCAL,T.DESCRIPCION AS 'TRONCAL'
            FROM RUTAS R 
            INNER JOIN TRONCAL T ON R.IDEMPRESA=T.IDEMPRESA AND R.COD_TRONCAL=T.COD_TRONCAL
            WHERE R.IDEMPRESA='{$COD_EMP}'";
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
