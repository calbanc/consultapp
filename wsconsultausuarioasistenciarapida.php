<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
    
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])&&isset($_GET["FechaActividad"])&&isset($_GET["IdZona"])&&isset($_GET["Sw_Aprobado"])&&isset($_GET["IdCuartel"])){
        
        $IdEmpresa=$_GET["IdEmpresa"];
        $FechaActividad=$_GET["FechaActividad"];
        $IdZona=$_GET["IdZona"];
        $Sw_Aprobado=$_GET["Sw_Aprobado"];
        $IdCuartel=$_GET["IdCuartel"];

       
        $sqlwhere="";

        if($Sw_Aprobado=='1'){
            $sqlwhere.="AR.SW_Aprobado='1' " ;
        }else{
            $sqlwhere.="AR.SW_Aprobado is null or AR.SW_Aprobado='0'" ;
        }

        if($IdZona=='55'){
            $sqlwhere.=" AND AR.IdCuartel='{$IdCuartel}'";
        }

     
       	
		$consulta="SELECT distinct NOMBRE,ApellidoPaterno,ApellidoMaterno,AR.IdUsuario
        from ANDROID_AsistenciaRapida AR
        Inner join Trabajador t on AR.IdUsuario=T.UsuarioSis
        WHERE AR.IdEmpresa='{$IdEmpresa}'  AND AR.FechaActividad='{$FechaActividad}' AND AR.IdZona='{$IdZona}' AND ".$sqlwhere ;
		
       
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