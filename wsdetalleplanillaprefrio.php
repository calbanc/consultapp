<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
	 
$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])){
        
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
       
        
        $consulta="SELECT RutCliente,NombreCliente from CLIENTES where  COD_EMP='{$COD_EMP}' and cod_tem='{$COD_TEM}'"; 
        
        $resultado=sqlsrv_query($conexion,$consulta);
            
        while($registros =sqlsrv_fetch_array($resultado)){
                $json[]=$registros;    
        }   
        echo json_encode($json);
              
              
            

   }else{
	   $resultar["id"]='Ws no Retorna';
	   $json[]=$resultar;
	   echo json_encode($json);
   }

}else{
    $resultar["LOTE"]='CONEXION';
    $json[]=$resultar;
    echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
	$json[]=$resultar;
	echo json_encode($json);
} 
	
?>  

