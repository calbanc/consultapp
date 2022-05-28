<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])&&isset($_GET["ZON"])&&isset($_GET["COD_PRO"])&&isset($_GET["COD_PRE"])&&isset($_GET["COD_CUA"])&&isset($_GET["FECHA_PAC"])&&isset($_GET["COD_FRI"])&&isset($_GET["COD_PACK"])
    &&isset($_GET["COD_ESP"])&&isset($_GET["COD_VAR"])&&isset($_GET["HORA_REC"])&&isset($_GET["LOTE"])&&isset($_GET["COD_ENV"])&&isset($_GET["COD_CAL"])&&isset($_GET["CANTIDAD"])&&isset($_GET["KILOS"])
    &&isset($_GET["TOTAL_KILOS"])&&isset($_GET["TIPOFRU_PK"])&&isset($_GET["NORDEN"])){
        
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $ZON=$_GET["ZON"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_PRE=$_GET["COD_PRE"];
        $COD_CUA=$_GET["COD_CUA"];
        $FECHA_PAC=$_GET["FECHA_PAC"];
        $COD_FRI=$_GET["COD_FRI"];
        $COD_ESP=$_GET["COD_ESP"];
        $COD_VAR=$_GET["COD_VAR"];
        $HORA_REC=$_GET["HORA_REC"];
        $COD_PACK=$_GET["COD_PACK"];
        $LOTE=$_GET["LOTE"];
        $COD_ENV=$_GET["COD_ENV"];
        $COD_CAL=$_GET["COD_CAL"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $KILOS=$_GET["KILOS"];
        $TOTAL_KILOS=$_GET["TOTAL_KILOS"];
        $TIPOFRU_PK=$_GET["TIPOFRU_PK"];
        $NORDEN=$_GET["NORDEN"];
       
        $TOTAL_KILOS=str_replace(',','.',$TOTAL_KILOS);

        $TIPOFRUT='C';
        $consulta="SELECT LOTE FROM ANDROID_FRUTA_COMERCIAL WHERE COD_EMP=? AND COD_TEM=? AND LOTE=? AND ZON=? ";
        $parametros=array($COD_EMP,$COD_TEM,$LOTE,$ZON);
        $resultado=sqlsrv_query($conexion,$consulta,$parametros);   

            if($registros=sqlsrv_fetch_array($resultado)){
                    if($registros['LOTE']==$LOTE){
                        $data=array('LOTE'=>$LOTE); 
                        $json[]=$data;
                        echo json_encode($json);
                    }  
                    
            }else{
                $consulta2="INSERT INTO ANDROID_FRUTA_COMERCIAL(COD_TEM,COD_EMP,ZON,COD_PRO,COD_PRE,COD_CUA,FECHA_PAC,COD_PACK,COD_FRI,COD_ESP,COD_VAR,HORA_REC,TIPOFRU,LOTE,COD_ENV,COD_CAL,CANTIDAD,KILOS,TOTAL_KILOS,TIPOFRU_PK,NRO_ORDEN,USUARIO)
                   VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) " ; 
               $parametros2=array($COD_TEM,$COD_EMP,$ZON,$COD_PRO,$COD_PRE,$COD_CUA,$FECHA_PAC,$COD_PACK,$COD_FRI,$COD_ESP,$COD_VAR,$HORA_REC,$TIPOFRUT,$LOTE,$COD_ENV,$COD_CAL,$CANTIDAD,$KILOS,$TOTAL_KILOS,$TIPOFRU_PK,$NORDEN,$usuario);
               //VALUES('{$COD_TEM}','{$COD_EMP}','{$ZON}','{$COD_PRO}','{$COD_PTE}',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) " ;  
               //$resultados=sqlsrv_query($conexion,$consulta2,$parametros2)   // VALUES('{$COD_TEM}','{$COD_EMP}','{$ZON}','{$COD_PRO}','{$COD_PRE}','{$COD_CUA}','{$FECHA_PAC}','{$COD_PACK}','{$COD_FRI}','{$COD_ESP}','{$COD_VAR}','{$HORA_REC}','{$TIPOFRUT}','{$LOTE}','{$COD_ENV}','{$COD_CAL}','{$CANTIDAD}','{$KILOS}','{$TOTAL_KILOS}','{$TIPOFRU_PK}','{$NORDEN}','{$usuario}') " ;  ;
              
               $resultados=sqlsrv_query($conexion,$consulta2,$parametros2);
               
                if($resultados){
                    $data=array('LOTE'=>$LOTE); 
                    $json[]=$data;
                    echo json_encode($json);
                }
              
              
            }

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