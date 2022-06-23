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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["campo"])&&isset($_GET["idbusca"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $campo=$_GET["campo"]; 
        $idbusca=$_GET["idbusca"];
        $sqlwhere="";
        if($idbusca=="CODIGO"){
            $sqlwhere=" AND CodigoCliente like '{$campo}%' ";
        }else{
            if($idbusca=="RUT"){
                $sqlwhere=" AND RutCliente like '{$campo}%' ";
            }else{
                $sqlwhere=" AND NombreCliente like '{$campo}%' ";
            }
        }



		$consulta="SELECT [CodigoCliente],[NombreCliente]
        FROM [erpfrusys].[dbo].[PROVEEDORES]
        WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' ".$sqlwhere;	
		
        

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