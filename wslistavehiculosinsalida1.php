<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
        $json=array();
        if(isset($_GET["COD_EMP"])
        &&isset($_GET["COD_TEM"])
        &&isset($_GET["Fecha_ingreso"])
        ){
            
            $COD_EMP=$_GET["COD_EMP"];
            $COD_TEM=$_GET["COD_TEM"];
            $Fecha_ingreso=$_GET["Fecha_ingreso"];
            $RUT=$_GET["RUT"];
            $PATENTE=$_GET["PATENTE"];
            $IDEMPRESATRABAJADOR=$_GET["IDEMPRESATRABAJADOR"];
            $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
            $TIPO=$_GET["TIPO"];
            $WHERE="";

           

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
            $ZON;
            $consultazona="SELECT ZON FROM PACKINGS_PARAMETROS WHERE IDUSUARIO='{$usuario}' AND COD_EMP='{$NUEVAEMPRESA}' AND COD_TEM='{$COD_TEM}' ";
            $resultadozona=sqlsrv_query($conexion,$consultazona);
            if($registrozona=sqlsrv_fetch_array($resultadozona)){
                $ZON=$registrozona['ZON'];
            }
            if(!empty($RUT)){
                $WHERE="AND RutConductor='{$RUT}'";
            }

            if(!empty($PATENTE)){
                $WHERE.="AND Patente LIKE '{$PATENTE}%'";
            }

            if(!empty($IDEMPRESATRABAJADOR)){
                $WHERE.="AND IDEMPRESATRAB='{$IDEMPRESATRABAJADOR}'";    
            }

            if($TIPO<>"TODOS"){
                $WHERE=" AND TIPO='{$TIPO}' ";
            }

            if(!empty($IDTRABAJADOR)){
                $WHERE.="AND IdTrabajador='{$IDTRABAJADOR}'";    
            }

         
                $consulta="SELECT NombreConductor,ISNULL(EmpresaTransporte,'') AS EmpresaTransporte ,ISNULL(Motivo,'')AS 'Motivo',CONVERT(varchar,Fecha_ingreso,120) as 'Fecha_ingreso',
                ISNULL(CONVERT(varchar,Fecha_salida,120),'') as 'Fecha_salida',Id,ISNULL(Patente,'') AS 'Patente',TIPO,RutConductor,ISNULL(Telefono,'') as 'Telefono',ISNULL(Contenedor,'') AS 'Contenedor'
                FROM ANDROID_RECEPCION_CAMIONES
                WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'  AND CONVERT(date,Fecha_ingreso,103)='{$Fecha_ingreso}'  ".$WHERE." and fecha_salida is null and ZON='{$ZON}' order by Fecha_salida  " ;
         
               
              
               
            
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