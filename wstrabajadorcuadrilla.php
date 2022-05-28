<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["usuario"])&&isset($_GET["clave"])){

    $usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
         
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");


$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdTrabajador_Enc"])&&isset($_GET["IdEmpresa"])){
       
        $IdTrabajador_Enc=$_GET["IdTrabajador_Enc"];
        $IdEmpresa=$_GET["IdEmpresa"];
	

		$consulta=" SELECT ct.IdEmpresa
        ,ct.IdCuadrilla
        ,ct.IdTrabajador
        ,REPLICATE('0', TipoDctoIden.Largo - LEN( t.RutTrabajador)) + LEFT(t.RutTrabajador, TipoDctoIden.Largo)as Dni
        ,t.ApellidoPaterno
        ,t.ApellidoMaterno
        ,t.Nombre
        ,t.IdEmpresa as Empresa_trabajador
        ,c.Descripcion
        ,c.IdCuadrilla
        ,c.IdTrabajador_Enc
        FROM [bsis_rem_afr].[dbo].[Cuadrilla_Trabajador] ct
        inner join Cuadrilla c on c.IdCuadrilla=ct.IdCuadrilla 
        inner join Trabajador t on t.IdTrabajador=ct.IdTrabajador and t.IdEmpresa=ct.IdEmpresa
        INNER JOIN TipoDctoIden   ON  TipoDctoIden.IdEmpresa = t.IdEmpresa AND TipoDctoIden.IdTipoDctoIden =t.IdTipoDctoIden
         where c.IdTrabajador_Enc='{$IdTrabajador_Enc}' and ct.IdEmpresa='{$IdEmpresa}'";
		
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
