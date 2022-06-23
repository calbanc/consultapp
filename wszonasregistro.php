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
            
            $consulta="SELECT tm.IdEmpresa,tm.Nombre as 'Empresa' , tm.IdZona,tm.Zona
			from(
			SELECT E.IdEmpresa,E.Nombre,Z.IdZona,Z.Nombre as 'Zona'
						FROM Zona Z
						INNER JOIN Empresa E ON Z.IdEmpresa=E.IdEmpresa 
						WHERE E.IdEmpresa='9'  and IdZona in('51','52','53','55','56','58','70','90','49','81')
					  union all
					  SELECT E.IdEmpresa,E.Nombre,Z.IdZona,Z.Nombre as 'zona'
						FROM Zona Z
						INNER JOIN Empresa E ON Z.IdEmpresa=E.IdEmpresa 
						WHERE E.IdEmpresa='14'  and IdZona in('80','50','51','55','59','58','54','53','40','57','41','49','81')
			)tm";
          

            
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
