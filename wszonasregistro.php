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
            
            $consulta="SELECT E.IdEmpresa,E.Nombre as 'Empresa',Z.IdZona,Z.Nombre as 'Zona'
            FROM Zona Z
            INNER JOIN Empresa E ON Z.IdEmpresa=E.IdEmpresa 
            WHERE E.IdEmpresa='9' OR E.IdEmpresa='14'
            ORDER BY E.IdEmpresa ASC";
          

            
        }else{
            
            $consulta="SELECT E.IdEmpresa,E.Nombre,Z.IdZona,Z.Nombre
            FROM Zona Z
            INNER JOIN Empresa E ON Z.IdEmpresa=E.IdEmpresa 
            WHERE E.IdEmpresa='{$COD_EMP}'
            ORDER BY E.IdEmpresa ASC";
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
