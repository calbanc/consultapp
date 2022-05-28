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
            if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDTRABAJADOR"])&&isset($_GET["IDMANGASTO"])
            &&isset($_GET["FECHA"])&&isset($_GET["ENTREGADINERO"])&&isset($_GET["NREPORT"]) ){
                
                $COD_EMP=$_GET["COD_EMP"];
                $COD_TEM=$_GET["COD_TEM"];
                $IDTRABAJADOR=$_GET["IDTRABAJADOR"];
                $IDMANGASTO=$_GET["IDMANGASTO"];
                $FECHA=$_GET["FECHA"];
                $ENTREGADINERO=$_GET["ENTREGADINERO"];
                $NREPORT=$_GET["NREPORT"];
                
                
                
         
                $consulta="DELETE FROM  APP_TRANSRENDICIONESCHOFERES        
                WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND IDTRABAJADOR='{$IDTRABAJADOR}' AND IDMANGASTO='{$IDMANGASTO}' AND FECHA='{$FECHA}' AND ENTREGADINERO='{$ENTREGADINERO}' AND NREPORT='{$NREPORT}'  ";

           
                $resultado=sqlsrv_query($conexion,$consulta);


                if($resultado){
                    echo 'registra';
                }else{
                    echo 'no registrado';
                }
             
                
                

            
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