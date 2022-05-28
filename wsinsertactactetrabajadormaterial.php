<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){
    $usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["LLAVE"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDTRABAJADOR"])&&isset($_GET["FECHA"])&&isset($_GET["SUBITEM"])&&
    isset($_GET["CANTIDAD"])&&isset($_GET["TIPO"])&&isset($_GET["ZON"])&&isset($_GET["PLANILLA"])&&isset($_GET["MOTIVO"])&&
    isset($_GET["COD_BUS"])&&isset($_GET["IDEMPRESATRABAJADOR"])&&isset($_GET["IDTRABAJADOR_RES"])&&isset($_GET["IDTRABAJADOR_JEF"])&&isset($_GET["IDAREA"])){
        

        $LLAVE=$_GET["LLAVE"];
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        $IDEMPRESATRABAJADOR=$_GET["IDEMPRESATRABAJADOR"];
        $FECHA=$_GET["FECHA"];
        $SUBITEM=$_GET["SUBITEM"];
        $CANTIDAD=$_GET["CANTIDAD"];
        $TIPO=$_GET["TIPO"];
        $ZON=$_GET["ZON"];
        $PLANILLA=$_GET["PLANILLA"];
        $MOTIVO=$_GET["MOTIVO"];
        $COD_BUS=$_GET["COD_BUS"];
        $IDTRABAJADOR_RES=$_GET["IDTRABAJADOR_RES"];
        $IDTRABAJADOR_JEF=$_GET["IDTRABAJADOR_JEF"];
        $IDAREA=$_GET["IDAREA"];
        $NUEVAEMPRESA;

        if(strlen($COD_EMP)<=2){
            $empresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='$COD_EMP'";

         
            $resultadoempresa=sqlsrv_query($conexion,$empresa);
            if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
                $NUEVAEMPRESA=$registroempresa['COD_EMP'];
            }
        }
       
        if($COD_EMP=='9'){
            $NUEVAEMPRESA='ARAP';
        }
        if($COD_EMP=='14'){
            $NUEVAEMPRESA='FORT';
        }


        if($IDTRABAJADOR_JEF=='invitado'){
            $IDTRABAJADOR_JEF='';
        }
        
        if($MOTIVO=='DETERIODO'){
            $MOTIVO='DETERIORO';
        }


        
        

        
        $consultaantes="SELECT * from ANDROID_CTACTE_TRABAJADOR_MATERIAL where cod_emp='{$NUEVAEMPRESA}' and cod_tem='{$COD_TEM}' and idtrabajador='{$IDTRABAJADOR}' and idempresatrabajador='{$IDEMPRESATRABAJADOR}' and subitem='{$SUBITEM}' and convert(date,fecha)='{$FECHA}'";
       
       
        $resultadoantes=sqlsrv_query($conexion,$consultaantes);
        if($registrosantes=sqlsrv_fetch_array($resultadoantes)){
            if($registrosantes['SUBITEM']==$SUBITEM){
                $data=array(
                    'id'=>'REGISTRA'
                ); 
                $json[]=$data;
                echo json_encode($json);
            }
        }else{

        


        		
		$consulta="INSERT INTO ANDROID_CTACTE_TRABAJADOR_MATERIAL(COD_EMP,COD_TEM,IDTRABAJADOR,IDEMPRESATRABAJADOR,FECHA,SUBITEM,CANTIDAD,TIPO,ZON,PLANILLA,MOTIVO,COD_BUS,IDTRABAJADOR_RES,IDTRABAJADOR_JEF,IDAREA,SW_IMPORTADO,usuario) 
        VALUES ('{$NUEVAEMPRESA}','{$COD_TEM}','{$IDTRABAJADOR}','{$IDEMPRESATRABAJADOR}','{$FECHA}','{$SUBITEM}','{$CANTIDAD}','{$TIPO}','{$ZON}','{$PLANILLA}','{$MOTIVO}','{$COD_BUS}','{$IDTRABAJADOR_RES}','{$IDTRABAJADOR_JEF}','{$IDAREA}','0','{$usuario}')";
          
        
        
		$resultado=sqlsrv_query($conexion,$consulta);
        
		 if($resultado){
             $data=array(
                 'id'=>'REGISTRA'
             ); 
             $json[]=$data;
             echo json_encode($json);
        
                }
                else{
					$data=array(
                        'id'=>'NO REGISTRA'
                    );
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
	echo "CONEXION FALLIDA";
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
?>






