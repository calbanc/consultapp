<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDEMPRESA"])&&isset($_GET["RUT"])){
        
        $IDEMPRESA=$_GET["IDEMPRESA"];
        $RUT=$_GET["RUT"];
		$consulta="SELECT DISTINCT Codigo=isnull(IdTrabajador,'') FROM Trabajador WITH(NOLOCK) WHERE RutTrabajador='{$RUT}' AND IdEmpresa = '{$IDEMPRESA}'";
        $resultado=sqlsrv_query($conexion,$consulta);   
            if($registros=sqlsrv_fetch_array($resultado)){

                    $consulta2="SELECT DISTINCT T.IdTrabajador,T.Nombre,T.ApellidoPaterno,T.ApellidoMaterno,T.Direccion,T.Telefono,C.IdZona as ZonaContrato,o.descripcion as puesto,Z.Nombre AS ZONA_LABORES FROM Trabajador T WITH(NOLOCK) 
                    INNER JOIN Contratos c WITH(NOLOCK) ON  c.IdEmpresa=t.IdEmpresa AND c.IdTrabajador=T.IdTrabajador 
                    INNER JOIN Oficio o WITH(NOLOCK) ON t.IdEmpresa=o.IdEmpresa AND C.IdOficio=o.IdOficio  
                    LEFT JOIN ZONA Z WITH(NOLOCK) ON Z.IDEMPRESA= T.IDEMPRESA AND Z.IDZONA=T.IdZonaLabores  
                    WHERE T.IdEmpresa = '{$IDEMPRESA}' AND T.IdTrabajador = '{$registros['Codigo']}' " ;      
                   
                   $resultados=sqlsrv_query($conexion,$consulta2);    
                  
                    if($registross=sqlsrv_fetch_array($resultados)){
                      
                        $json[]=$registross;
                        echo json_encode($json); 
                    }
                    
                    
            }

   }else{
	   $resultar["id"]='Ws no Retorna';
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