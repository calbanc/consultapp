<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
    if(isset($_GET["cod_emp"]) &&isset($_GET["cod_tem"])&&isset($_GET["dni"])&&isset($_GET["placa"])){
        
        $cod_emp=$_GET["cod_emp"];
        $cod_tem=$_GET["cod_tem"];  
        $dni=$_GET["dni"];
        $placa=$_GET["placa"];
        


        if(is_numeric($cod_emp)&&$cod_emp<>'9'){
            $consultaempresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='{$cod_emp}'";
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
        $consulta1="SELECT ZON FROM PACKINGS_PARAMETROS WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$cod_tem}' AND IDUSUARIO='{$usuario}' ";
    
       
        $resultado2=sqlsrv_query($conexion,$consulta1);
        $registros=sqlsrv_fetch_array($resultado2);
        $idzona=$registros['ZON'];

      
        $where="";

        if(!($dni=="TODOS")){
            
            $where.="AND RUTCONDUCTOR='{$dni}'";
        }

        if(!($placa=="TODOS")){
            $where.="AND Patente LIKE '{$placa}%'";
        }
       
        
       
        

        $consultaantes="SELECT * FROM ANDROID_RECEPCION_CAMIONES WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$cod_tem}'  and ZON='{$idzona}' AND Fecha_ingreso is null ".$where ;
        

        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        while($registross=sqlsrv_fetch_array($resultadoantes)){
           
                $data=$registross;
                $json[]=$data;
           
            		
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