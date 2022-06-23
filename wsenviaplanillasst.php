<?PHP
$hostname_localhost="192.168.60.8\SQLEXPRESS";

$info=array("Database"=>"PRUEBAS","UID"=>"sa","PWD"=>"123456","CharacterSet"=>"UTF-8");



        $conexion = sqlsrv_connect($hostname_localhost,$info);
        if($conexion){
            
            $json=array();
           
            if(isset($_GET["IDEMPRESA"])&&isset($_GET["IDTEMPORADA"])&&isset($_GET["IDPLANILLA"])
            &&isset($_GET["usuario"])&&isset($_GET["FECHA"])&&isset($_GET["HORA"])){
              
                $IDEMPRESA=$_GET["IDEMPRESA"];
                $IDTEMPORADA=$_GET["IDTEMPORADA"];
                $IDPLANILLA=$_GET["IDPLANILLA"];
                $USUARIO=$_GET["usuario"];
                $FECHA=$_GET["FECHA"];
                $HORA=$_GET["HORA"];
                

                $dtz = new DateTimeZone("America/Lima");
                $dt = new DateTime("now", $dtz);


                $fecharegistro = $dt->format("Y-m-d") . "T" . $dt->format("H:i:s");
                
                
                $consultaidregistro="SELECT ISNULL(MAX(IDREGISTRO),0)+1 as 'IDREGISTRO' FROM TIT_DATOS WHERE IDEMPRESA='{$IDEMPRESA}' AND IDTEMPORADA='{$IDTEMPORADA}' ";

                $resultadoidregistro=sqlsrv_query($conexion,$consultaidregistro);
                if($registro=sqlsrv_fetch_array($resultadoidregistro,SQLSRV_FETCH_ASSOC)){
                    $idregistro=$registro['IDREGISTRO'];
                    $insert="INSERT INTO TIT_DATOS(IDEMPRESA,IDTEMPORADA,IDREGISTRO,IDPLANILLA,USUARIO,FECHA,HORA)VALUES('{$IDEMPRESA}','{$IDTEMPORADA}','{$idregistro}','{$IDPLANILLA}','{$USUARIO}','{$FECHA}','{$HORA}')";
                 
                    $execinsert=sqlsrv_query($conexion,$insert);
                    if($execinsert){
                        $resulta["PLANILLABD"]=$idregistro;
                        $json[]=$resulta;
                        echo json_encode($json);
                    }else{
                        $resulta["PLANILLABD"]='NO SE PUDO INSERTAR';
                        $json[]=$resulta;
                        echo json_encode($json);
                    }
                    

                }
                

                

                
               
            } else{
                    $resultar["message"]='Ws no Retorna';
                    $json[]=$resultar;
                    echo json_encode($json);
                }

            
        }else{
            echo "CONEXION FALLIDA";
        }
    

	
?>

	
