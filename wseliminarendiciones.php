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
            if(isset($_GET["IDFOTO"])){
                
                $IDFOTO=$_GET["IDFOTO"];
                
                
         
                $consulta="DELETE FROM  APP_TRANSRENDICIONESCHOFERES WHERE IDFOTO='{$IDFOTO}' ";

           
                $resultado=sqlsrv_query($conexion,$consulta);


                if($resultado){
                    $resultar["ELIMINAR"]='ELIMINADO';
                    $json[]=$resultar;
                }else{
                    $resultar["ELIMINAR"]='ERROR';
                    $json[]=$resultar;
                }
             
                echo json_encode($json);
                

            
            }else{
                $resultar["message"]='faltan datos';
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