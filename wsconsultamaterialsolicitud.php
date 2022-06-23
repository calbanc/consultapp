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
        
        if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["ZON"])){
            
            $COD_EMP=$_GET["COD_EMP"];
            $COD_TEM=$_GET["COD_TEM"];
            $ZON=$_GET["ZON"];
          
            
            $sqlwhere="";

            if($ZON!='TODOS'){
                $sqlwhere.="  AND DSC.ZON='{$ZON}' ";
            }
       
            
             $consulta="SELECT DISTINCT DSC.SUBITEM,SUB.DES_SITEM
             FROM DETALLE_SOLICITUD_DE_COMPRA DSC
             INNER JOIN SUBITEM SUB ON DSC.COD_EMP=SUB.COD_EMP AND DSC.COD_TEM=SUB.COD_TEM AND DSC.SUBITEM=SUB.SUBITEM
             WHERE DSC.COD_EMP='{$COD_EMP}' AND DSC.COD_TEM='{$COD_TEM}'  " .$sqlwhere;
             
       

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