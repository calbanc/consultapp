<?PHP

$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["IDEMPRESA"])&&isset($_GET["IDTEMPORADA"])&&isset($_GET["IDZONA"])&&isset($_GET["FECHA"])
    &&isset($_GET["IDAREA"])&&isset($_GET["IDLUGAR"])&&isset($_GET["IDTRABAJADOR"])&&isset($_GET["DESCRIPCION_HALLAZGO"])&&isset($_GET["MEDIDAS_HALLAZGO"])
    &&isset($_GET["IDNIVELHALLAZGO"])&&isset($_GET["IDPLAZOHALLAZGO"])&&isset($_GET["ESTADO"])&&isset($_GET["IDFOTO"])&&isset($_GET["TURNO"])
    &&isset($_GET["CONSECUENCIAS"])&&isset($_GET["ID"])&&isset($_GET["CAUSAS"])){
        
	
		$IDEMPRESA=$_GET["IDEMPRESA"];
        $IDTEMPORADA=$_GET["IDTEMPORADA"];
        $IDZONA=$_GET["IDZONA"];
        $FECHA=$_GET["FECHA"];
        $IDAREA=$_GET["IDAREA"];
        $IDLUGAR=$_GET["IDLUGAR"];
        $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        $DESCRIPCION_HALLAZGO=$_GET["DESCRIPCION_HALLAZGO"];
        $MEDIDAS_HALLAZGO=$_GET["MEDIDAS_HALLAZGO"];
        $IDNIVELHALLAZGO=$_GET["IDNIVELHALLAZGO"];
        $ESTADO=$_GET["ESTADO"];
        $IDFOTO=$_GET["IDFOTO"];
        $TURNO=$_GET["TURNO"];
        $CONSECUENCIAS=$_GET["CONSECUENCIAS"];
        $ID=$_GET["ID"];
        $CAUSAS=$_GET["CAUSAS"];
        $IDPLAZOHALLAZGO=$_GET["IDPLAZOHALLAZGO"];
        $PLAZO=$_GET["PLAZO"];
        $TIPO_HALLAZGO=$_GET["TIPO_HALLAZGO"];


        $consultaantes="SELECT IDFOTO,PLANILLA FROM HALLAZGOS_ANDROID WHERE IDEMPRESA='{$IDEMPRESA}' AND IDTEMPORADA='{$IDTEMPORADA}' AND IDFOTO='{$IDFOTO}' ";
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);

        if($registroantes=sqlsrv_fetch_array($resultadoantes)){
                $PLANILLA=$registroantes['PLANILLA'];
                if($registroantes['IDFOTO']==$IDFOTO){
                    $resultar["RESULTADO"]=$IDFOTO;
                    $resultar["RESULTADO"].='-';
                    $resultar["RESULTADO"].=$PLANILLA;
                    $json[]=$resultar;
                    echo json_encode($json);
                }

        }else{
            $consultaplanilla="SELECT ISNULL(MAX(PLANILLA),0) +1 as 'PLANILLA' from HALLAZGOS_ANDROID WHERE IDEMPRESA='{$IDEMPRESA}' AND IDTEMPORADA='{$IDTEMPORADA}' AND IDZONA='{$IDZONA}'";

            $resultadoplanilla=sqlsrv_query($conexion,$consultaplanilla);
            
            if($registroplanilla=sqlsrv_fetch_array($resultadoplanilla)){
                $PLANILLA=$registroplanilla['PLANILLA'];
            }
            
            if($IDNIVELHALLAZGO=='null'){
                $IDNIVELHALLAZGO='';
            }

            $consulta="INSERT INTO HALLAZGOS_ANDROID(IDEMPRESA,IDTEMPORADA,IDZONA,PLANILLA,FECHA,IDAREA,IDLUGAR,IDTRABAJADOR,DESCRIPCION_HALLAZGO,MEDIDAS_HALLAZGO,IDNIVELHALLAZGO,IDPLAZOHALLAZGO,ESTADO,USUARIO,IDFOTO,TURNO,CONSECUENCIAS,CAUSAS,PLAZO,TIPO)
            VALUES ('{$IDEMPRESA}','{$IDTEMPORADA}','{$IDZONA}','{$PLANILLA}','{$FECHA}','{$IDAREA}','{$IDLUGAR}','{$IDTRABAJADOR}','{$DESCRIPCION_HALLAZGO}','{$MEDIDAS_HALLAZGO}','{$IDNIVELHALLAZGO}','{$IDPLAZOHALLAZGO}','{$ESTADO}','{$usuario}','{$IDFOTO}','{$TURNO}','{$CONSECUENCIAS}','{$CAUSAS}','{$PLAZO}','{$TIPO_HALLAZGO}')";
            
          
            
            $resultado=sqlsrv_query($conexion,$consulta);
            if($resultado){
                $resultar["RESULTADO"]=$IDFOTO;
                $resultar["RESULTADO"].='-';
                $resultar["RESULTADO"].=$PLANILLA;
                $json[]=$resultar;
                echo json_encode($json);
            }else{
                $resultar["RESULTADO"]='NO REGISTRA';   
                $json[]=$resultar;
                echo json_encode($json);
    
            }
        }



       


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
