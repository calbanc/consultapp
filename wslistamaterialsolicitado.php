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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["FECHA"])&&isset($_GET["USUARIO"])&&isset($_GET["SUBITEM"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $FECHA=$_GET["FECHA"];
        $USUARIO=$_GET["USUARIO"];
        $SUBITEM=$_GET["SUBITEM"];
        $SQLWHERE="";

        if($USUARIO=='TODOS'){

        }else{
            $SQLWHERE.=" AND DM.USUARIO='{$USUARIO}'  ";
        }

        if($SUBITEM=='TODOS'){

        }else{
            $SQLWHERE.=" AND DM.SUBITEM='{$SUBITEM}'";
        }
		
		$consulta="SELECT DISTINCT [MATERIAL]=VM.DES_SITEM+' CODIGO='+DM.SUBITEM,DM.LLAVE,DM.USUARIO,DM.PLANILLA,DM.CAN_DES,DM.LLAVE 
        FROM DESPACHOMATERIALES_ANDROID DM
        INNER JOIN VIEW_MATERIALES_AYUDA VM ON DM.COD_EMP=VM.COD_EMP AND DM.COD_TEM=VM.COD_TEM AND VM.SUBITEM=DM.SUBITEM
        WHERE DM.COD_EMP='{$COD_EMP}' AND DM.COD_TEM='{$COD_TEM}' AND DM.FECHA='{$FECHA}'" .$SQLWHERE ." ORDER BY DM.PLANILLA DESC" ;
		
   

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