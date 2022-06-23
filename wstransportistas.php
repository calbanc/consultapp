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
       
        if(is_numeric($COD_EMP)&&$COD_EMP<>'9'){
                $consultaempresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='{$COD_EMP}'";
                $resultadoempresa=sqlsrv_query($conexion,$consultaempresa);
                if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
                        $NUEVAEMPRESA=$registroempresa['COD_EMP'];
                }
        }else{
                if($COD_EMP=='9'){
                        $NUEVAEMPRESA='ARAP';
                }
                
        }
        
        $COD_EMP=$NUEVAEMPRESA;
        
        $consulta="SELECT COD_TRP,NOM_TRP 
        FROM TRANSPORTISTAS 
         where  COD_EMP='{$COD_EMP}' and COD_TEM='{$COD_TEM}'"; 

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

