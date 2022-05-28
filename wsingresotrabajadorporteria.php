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
    &&isset($_GET["FECHA"])
    &&isset($_GET["HORAINGRESO"]) 
    &&isset($_GET["IDTRABAJADOR"])
    &&isset($_GET["IDEMPRESATRABAJADOR"])
    &&isset($_GET["PATENTE"])
    &&isset($_GET["RUT"])
    &&isset($_GET["NOMBRE"])
    &&isset($_GET["TEMPERATURA"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];  
        $FECHA=$_GET["FECHA"];
        $HORAINGRESO=$_GET["HORAINGRESO"];
        $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
        $IDEMPRESATRABAJADOR=$_GET["IDEMPRESATRABAJADOR"];
        $PATENTE=strtoupper($_GET["PATENTE"]) ;
        $TEMPERATURA=$_GET["TEMPERATURA"];
        $RUT=$_GET["RUT"];
        $NOMBRE=strtoupper($_GET["NOMBRE"]) ;

      


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
        $consulta1="SELECT ZON FROM PACKINGS_PARAMETROS WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDUSUARIO='{$usuario}' ";
        
       
        $resultado2=sqlsrv_query($conexion,$consulta1);
        $registros=sqlsrv_fetch_array($resultado2);
        $idzona=$registros['ZON'];

        if(empty($PATENTE)){
            $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,UsuarioSis_ingreso,Sw_Despachado,ZON,IDEMPRESATRAB,IdTrabajador,temperatura,TIPO)
            VALUES('{$COD_EMP}','{$COD_TEM}','{$HORAINGRESO}','{$RUT}','{$NOMBRE}','{$usuario}','0','{$idzona}','{$IDEMPRESATRABAJADOR}','{$IDTRABAJADOR}','{$TEMPERATURA}','TRABAJADOR')";
           
        }else{
            $consulta="INSERT INTO ANDROID_RECEPCION_CAMIONES(COD_EMP,COD_TEM,Fecha_ingreso,RutConductor,NombreConductor,Patente,UsuarioSis_ingreso,Sw_Despachado,ZON,IDEMPRESATRAB,IdTrabajador,temperatura,TIPO)
            VALUES('{$COD_EMP}','{$COD_TEM}','{$HORAINGRESO}','{$RUT}','{$NOMBRE}','{$PATENTE}','{$usuario}','0','{$idzona}','{$IDEMPRESATRABAJADOR}','{$IDTRABAJADOR}','{$TEMPERATURA}','TRABAJADOR')";

        }



                    
                    
                    $resultado=sqlsrv_query($conexion,$consulta);

                    if($resultado){
                        $data=array(
                            'id'=>'REGISTRADO'
                        );
                        $json[]=$data;
                        echo json_encode($json);
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