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
			if(isset($_GET["COD_EMP"])&&isset($_GET["IDTRABAJADOR"]) &&isset($_GET["COD_TEM"]))	{
				
				
				$COD_EMP=$_GET["COD_EMP"];
				$IDTRABAJADOR=$_GET["IDTRABAJADOR"];
                $COD_TEM=$_GET["COD_TEM"];
              
           
                    if($COD_EMP=='9'){
                        $NUEVAEMPRESA='ARAP';
                    }else{
                        $consultaempresa="SELECT COD_EMP FROM EMPRESAS WHERE ID_EMPRESA_REM='{$COD_EMP}'";
                        $resultadoempresa=sqlsrv_query($conexion,$consultaempresa);
                        if($registroempresa=sqlsrv_fetch_array($resultadoempresa)){
                            $NUEVAEMPRESA=$registroempresa['COD_EMP'];
                        }
                    }
                    
                
             
				$consulta="SELECT DISTINCT PATENTE
                FROM [erpfrusys].[dbo].[MAQUINARIAS]
                where COD_EMP='{$NUEVAEMPRESA}' and COD_TEM='{$COD_TEM}' and COD_TRAB='{$IDTRABAJADOR}' and PATENTE is not null";
				
                $resultado=sqlsrv_query($conexion,$consulta);
				
				while($registro =sqlsrv_fetch_array($resultado)){
					$json[]=$registro;
				}

				
				echo json_encode($json);
				

			}else{
				$resultar["message"]='Faltan parametros';
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