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
    if(isset($_GET["COD_EMP"])
    &&isset($_GET["COD_TEM"])
    &&isset($_GET["FECHA_PAC"])
    &&isset($_GET["COD_PACK"])
    &&isset($_GET["COD_PRO"])
    &&isset($_GET["COD_FRI"])
    &&isset($_GET["COD_ESP"])
    &&isset($_GET["COD_VAR"])
    &&isset($_GET["ALTURA"])
    &&isset($_GET["TIPO_LOT"])
    &&isset($_GET["LOTE"])
    &&isset($_GET["COD_ENV"])
    &&isset($_GET["COD_ETI"])
    &&isset($_GET["COD_EMB"])
    &&isset($_GET["PLU"])
    &&isset($_GET["CAJAS"])
    &&isset($_GET["COD_CAT"])
    &&isset($_GET["COD_CAL"])
    &&isset($_GET["ZON"])
    &&isset($_GET["COD_ENVOP"])
    &&isset($_GET["COD_VAR_ETI"])
    &&isset($_GET["COD_BP"])
    &&isset($_GET["COD_MER4"])
    &&isset($_GET["NRO_MIX"])
    &&isset($_GET["NRO_ORDEN"])
    &&isset($_GET["COD_PRE"])
    &&isset($_GET["COD_CUA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $FECHA_PAC=$_GET["FECHA_PAC"];
        $COD_PACK=$_GET["COD_PACK"];
        $COD_PRO=$_GET["COD_PRO"];
        $COD_FRI=$_GET["COD_FRI"];
        $COD_ESP=$_GET["COD_ESP"];
        $COD_VAR=$_GET["COD_VAR"];
        $ALTURA=$_GET["ALTURA"];
        $TIPO_LOT=$_GET["TIPO_LOT"];
        $LOTE=$_GET["LOTE"];
        $COD_ENV=$_GET["COD_ENV"];
        $COD_ETI=$_GET["COD_ETI"];
        $COD_EMB=$_GET["COD_EMB"];
        $PLU=$_GET["PLU"];
        $CAJAS=$_GET["CAJAS"];
        $COD_CAT=$_GET["COD_CAT"];
        $COD_CAL=$_GET["COD_CAL"];
        $ZON=$_GET["ZON"];
        $COD_ENVOP=$_GET["COD_ENVOP"];
        $COD_VAR_ETI=$_GET["COD_VAR_ETI"];
        $COD_BP=$_GET["COD_BP"];
        $COD_MER4=$_GET["COD_MER4"];
        $NRO_MIX=$_GET["NRO_MIX"];
        $NRO_ORDEN=$_GET["NRO_ORDEN"];
        $COD_PRE=$_GET["COD_PRE"];
        $COD_CUA=$_GET["COD_CUA"];
        $TEMP_PAC=$_GET["TEMP_PAC"];
        

        $consultaantes="SELECT * FROM PROPACKLOTE_MASIVO WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND ZON='{$ZON}' AND LOTE='{$LOTE}'  ";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registrosantes=sqlsrv_fetch_array($resultadoantes)){
                if($registrosantes['LOTE']==$LOTE){
                    $resulta["id"]='REGISTRA';
                    $json[]=$resulta;
                    echo json_encode($json);
                }
        }else{
		$consulta="INSERT INTO PROPACKLOTE_MASIVO (COD_TEM, COD_EMP,NPROCESO,FECHA_PAC,COD_PACK,COD_PRO,COD_FRI,COD_ESP,COD_VAR,ALTURA,TIPO_LOT,LOTE,COD_ENV,COD_ETI,COD_EMB,PLU,CAJAS,COD_CAT,COD_CAL,ZON,COD_ENVOP,COD_VAR_ETI, COD_BP,COD_MER4,NRO_MIX,NRO_ORDEN,COD_PRE,COD_CUA,TEMP_PAC)
        VALUES ('{$COD_TEM}','{$COD_EMP}',NULL,'{$FECHA_PAC}','{$COD_PACK}','{$COD_PRO}','{$COD_FRI}','{$COD_ESP}','{$COD_VAR}','{$ALTURA}','{$TIPO_LOT}','{$LOTE}','{$COD_ENV}','{$COD_ETI}','{$COD_EMB}','{$PLU}','{$CAJAS}', '{$COD_CAT}', '{$COD_CAL}','{$ZON}', '{$COD_ENVOP}', '{$COD_VAR_ETI}', '{$COD_BP}', '{$COD_MER4}', '{$NRO_MIX}', '{$NRO_ORDEN}', '{$COD_PRE}','{$COD_CUA}','{$TEMP_PAC}')";
		
		$resultado=sqlsrv_query($conexion,$consulta);
        if($resultado){
            $resulta["id"]='REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
            else{
                $resulta["id"]='NO REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
    

        }
    }else{
        $resultar["id"]='FALTAN DATOS';
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