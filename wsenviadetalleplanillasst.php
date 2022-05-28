<?PHP
$hostname_localhost="192.168.60.8\SQLEXPRESS";

$info=array("Database"=>"PRUEBAS","UID"=>"sa","PWD"=>"123456","CharacterSet"=>"UTF-8");



        $conexion = sqlsrv_connect($hostname_localhost,$info);
        if($conexion){
            
            $json=array();
           
            if(isset($_GET["IDEMPRESA"])&&isset($_GET["IDTEMPORADA"])&&isset($_GET["IDREGISTRO"])
            &&isset($_GET["IDORDEN"])&&isset($_GET["DESCRIPCION"])){
              
                $IDEMPRESA=$_GET["IDEMPRESA"];
                $IDTEMPORADA=$_GET["IDTEMPORADA"];
                $IDREGISTRO=$_GET["IDREGISTRO"];
                $IDORDEN=$_GET["IDORDEN"];
                $DESCRIPCION=$_GET["DESCRIPCION"];
                
                $insert="INSERT INTO DETALLE_DATOS(IDEMPRESA,IDTEMPORADA,IDREGISTRO,IDORDEN,DESCRIPCION) VALUES('{$IDEMPRESA}','{$IDTEMPORADA}','{$IDREGISTRO}','{$IDORDEN}','{$DESCRIPCION}')";

                $exectinsert=sqlsrv_query($conexion,$insert);
                if($exectinsert){
                    $resultar["RESPUESTA"]='REGISTRADO';
                    $json[]=$resultar;
                    echo json_encode($json);
                }else{
                    $resultar["RESPUESTA"]='NO INGRESADO';
                    $json[]=$resultar;
                    echo json_encode($json);
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

	
