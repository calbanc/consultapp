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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["CANTIDAD"])&&isset($_GET["COD_PRO"])
    &&isset($_GET["COD_CUA"])&&isset($_GET["PLANILLA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_CUA=$_GET["COD_CUA"];
        $PLANILLA=$_GET["PLANILLA"];
        
      
            $consultaplanilla="SELECT CANTIDAD from ANDROID_COSECHA_HUERTO WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' and COD_PRO='{$COD_PRO}' AND COD_CUA='{$COD_CUA}' AND PLANILLA='{$PLANILLA}' ";
          
            $query=sqlsrv_query($conexion,$consultaplanilla);
            if($registro =sqlsrv_fetch_array($query)){
                $resultar["MENSAJE"]='OK';
         

               
            }else{
                if($CANTIDAD=="0"){
                    $resultar["MENSAJE"]='OK';
                }else{
                    $insert="INSERT INTO ANDROID_COSECHA_HUERTO(COD_EMP,COD_TEM,COD_PRO,COD_CUA,PLANILLA,CANTIDAD)VALUES
                    ('{$COD_EMP}','{$COD_TEM}','{$COD_PRO}','{$COD_CUA}','{$PLANILLA}','{$CANTIDAD}') ";   
                    $resultado=sqlsrv_query($conexion,$insert);
           
                    if($resultado){
                        $resultar["MENSAJE"]='OK';
                    }else{
                        $resultar["MENSAJE"]='ERROR';
                    }
            
                }
                    
            }
       

            $json[]=$resultar; 
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