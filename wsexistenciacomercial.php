<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

$usuario=$_GET["usuario"];
$clave=$_GET["clave"];
	 
$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])&&isset($_GET["ZON"])){
        
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $ZON=$_GET["ZON"];
        
        $consulta="SELECT E.COD_TEM,E.COD_EMP,CONVERT(varchar,E.FECHA_RPA,23) as FECHA,E.COD_PACK,E.COD_PRO,P.NOM_PRO,E.COD_FRI,E.COD_ESP,ES.NOM_ESP,E.COD_VAR,V.NOM_VAR,E.LOTE,[COD_ENV]=S.NOM_ENV,E.ZON,E.CANTIDAD,E.KILOS,E.TOTAL_KILOS,E.COD_PRE,E.COD_CUA,E.COD_CAL,E.TIPOFRU
        FROM EXISPACK E 
        INNER JOIN PRODUCTORES  P ON  E.COD_PRO = P.COD_PRO AND  E.COD_TEM = P.COD_TEM AND  E.COD_EMP = P.COD_EMP 
        INNER JOIN ESPECIE ES ON  E.COD_ESP = ES.COD_ESP AND  E.COD_TEM = ES.COD_TEM AND  E.COD_EMP = ES.COD_EMP  
        INNER JOIN VARIEDAD  V ON  E.COD_ESP = V.COD_ESP AND  E.COD_VAR = V.COD_VAR AND  E.COD_TEM = V.COD_TEM AND  E.COD_EMP = V.COD_EMP  
        INNER JOIN FRIOS F ON  E.COD_FRI = F.COD_FRI AND  E.COD_TEM = F.COD_TEM AND  E.COD_EMP = F.COD_EMP 
        INNER JOIN ENVASE S ON S.COD_ENV=E.COD_ENV AND S.COD_EMP=E.COD_EMP AND S.COD_TEM=E.COD_TEM
        where E.COD_TEM='{$COD_TEM}' AND E.COD_EMP='{$COD_EMP}'  AND E.ZON='{$ZON}'"; 
        

       
        // AND E.TIPOFRU<>'E'         
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