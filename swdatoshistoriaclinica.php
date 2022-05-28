<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){
	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	$info=array("Database"=>"bsis_rem_afr","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&& isset($_GET["DNI"])&&isset($_GET["IdHistoriaClinica"])){
        $COD_EMP=$_GET["COD_EMP"];
        $DNI=$_GET["DNI"];
        $IdHistoriaClinica=$_GET["IdHistoriaClinica"];
        
		


        $sqlwhere="";
        if($DNI!='TODOS'){
			if(strlen($DNI)==7){
				$COD_EMP=substr($COD_EMP,0);
				$IdTrabajador=substr($DNI,1,6);
				$sqlwhere.="IdEmpresa='{$COD_EMP}' AND IdTrabajador='{$IdTrabajador}' ";
			}else{
				if(strlen($DNI)>7){
					$sqlwhere.=" IdEmpresa='{$COD_EMP}' AND DNI='{$DNI}' ";     
				}
			}
           
        }

        if($IdHistoriaClinica!='TODOS'){
            $sqlwhere.="  IdEmpresa='{$COD_EMP}'  AND IdHistoriaClinica='{$IdHistoriaClinica}' ";
        }

		
		
		$consulta="SELECT * FROM ViewDatosHistoriaClinicaAndroid WHERE  ".$sqlwhere ;
        
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
        if($registross=sqlsrv_fetch_array($resultado)){
                      
            $json[]=$registross;
            echo json_encode($json); 
        }
	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	$resultar["CONEXION"]='CONEXION';
	$json[]=$resultar;
	echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
?>