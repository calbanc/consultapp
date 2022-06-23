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
            if(isset($_GET["fecha"])){
                
                $fecha=$_GET["fecha"];
               
                $consultaantes="SELECT DISTINCT af.Grupo as 'NROGRUPO',af.CodigoCampo, af.Tipo_ingreso,af.IdEmpresa as 'Id Empresa Ingreso',
                e.Nombre as 'Empresa Ingreso',af.IdZona as 'Id Zona ingreso',z.Nombre as 'Zona ingreso',[Troncal]=af.COD_TRONCAL+' - '+tr.DESCRIPCION,[Ruta]=af.COD_RUTA+' - '+r.DESCRIPCION
                FROM ANDROID_Fotografias AF
                LEFT JOIN TRONCAL tr on tr.IDEMPRESA=af.IdEmpresa and tr.COD_TRONCAL=af.COD_TRONCAL
                LEFT JOIN RUTAS r on r.IDEMPRESA=af.IdEmpresa and r.COD_RUTA=af.COD_RUTA and r.COD_TRONCAL=af.COD_TRONCAL
                LEFT JOIN Empresa E on e.IdEmpresa=af.IdEmpresa
                LEFT JOIN Zona z on z.IdEmpresa=af.IdEmpresa and z.Idzona=af.IdZona
                Where af.Fecha='{$fecha}' ";
                $resultadoantes=sqlsrv_query($conexion,$consultaantes);
                while($registros=sqlsrv_fetch_array($resultadoantes)){
                    $json[]=$registros;
                                     
                }
             
                echo json_encode($json);
            
              
                    
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