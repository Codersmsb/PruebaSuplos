<?php
require_once 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "suplos";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlEmpleaados = mysqli_query($conexionBD,"SELECT * FROM evento WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlEmpleaados) > 0){
        $empleaados = mysqli_fetch_all($sqlEmpleaados,MYSQLI_ASSOC);
        echo json_encode($empleaados);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}


// Código para listar datos de Excel      
if(isset($_GET["searchTerm"])){
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    $excel = './clasificador.xls';
    $tipoArchivo = \PhpOffice\PhpSpreadsheet\IOFactory::identify($excel);
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($tipoArchivo);
    $leerArchivo = $reader->load($excel);
    $registros = $leerArchivo->getActiveSheet()->toArray();

    header('Content-Type: application/json');
    echo json_encode($registros); //esta contiene el json
}

//insertar evento o proceso
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $objeto=$data->objeto;
    $descripcion=$data->descripcion;
     $tipomoneda=$data->tipomoneda;
     $presupuesto=$data->presupuesto;
     $actividad=$data->actividad;
     $responsable=$data->responsable;
        if(($objeto!="")&&($descripcion!="")&&($tipomoneda!="")&&($presupuesto!="")
        &&($actividad!="")&&($responsable!="")){
            
    $sqlEmpleaados = mysqli_query($conexionBD,"INSERT INTO evento(objeto,descripcion,tipomoneda,presupuesto,actividad,responsable) VALUES('$objeto','$descripcion','$tipomoneda','$presupuesto','$actividad','$responsable') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}

//Listar objetos de eventos para los cronogramas y documentacion de peticiones
 if(isset($_GET["eventos"])){
    $sqlEmpleaados = mysqli_query($conexionBD,"SELECT id FROM evento");
    if(mysqli_num_rows($sqlEmpleaados) > 0){
        $empleaados = mysqli_fetch_all($sqlEmpleaados,MYSQLI_ASSOC);
       echo json_encode($empleaados);
    }
    else{ echo json_encode([["success"=>0]]); }
 }


 //insertar cronograma
 if(isset($_GET["crono"])){
    $data = json_decode(file_get_contents("php://input"));
    $id_evento=$data->id_evento;
    $fecha_inicio=$data->fecha_inicio;
    $hora_inicio=$data->hora_inicio;
    $fecha_fin=$data->fecha_fin;
    $hora_fin=$data->hora_fin;
    $fecha_actual = date('Y-m-d H:i:s');

    if((($fecha_inicio.' '.$hora_inicio)<=$fecha_actual)&&!(($fecha_fin.' '.$hora_fin)<=$fecha_actual)){
        print_r("publicado");
        $estado="publicado";
    }
    elseif((($fecha_fin.' '.$hora_fin)<=$fecha_actual)){
        print_r("evaluacion");
        $estado="evaluacion";
    }else{
        print_r("activo");
        $estado="activo";
    }
        if(($id_evento!="")&&($fecha_inicio!="")&&($hora_inicio!="")&&($fecha_fin!="")
        &&($hora_fin!="")){
    $sqlEmpleaados = mysqli_query($conexionBD,"INSERT INTO cronograma(id_evento,fecha_inicio,hora_inicio,fecha_fin,hora_fin,estado) VALUES('$id_evento','$fecha_inicio','$hora_inicio','$fecha_fin','$hora_fin','$estado') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}

 //insertar documentacion de peticion
 if(isset($_GET["doc"])){
    $data = json_decode(file_get_contents("php://input"));
    $id_evento=$data->id_evento;
    $titulo=$data->titulo;
    $descripcion=$data->descripcion;
        if(($id_evento!="")&&($titulo!="")&&($descripcion!="")){
    $sqlEmpleaados = mysqli_query($conexionBD,"INSERT INTO documentacion(id_evento,titulo,descripcion) VALUES('$id_evento','$titulo','$descripcion') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}

//Listar eventos y cronogramas para las consultas
if(isset($_GET["cns"])){
    $sqlEmpleaados = mysqli_query($conexionBD,"SELECT *
    FROM evento
    INNER JOIN cronograma
    ON evento.id = cronograma.id_evento;");
    if(mysqli_num_rows($sqlEmpleaados) > 0){
        $empleaados = mysqli_fetch_all($sqlEmpleaados,MYSQLI_ASSOC);
       echo json_encode($empleaados);
    }
    else{ echo json_encode([["success"=>0]]); }
 }

 if (isset($_GET["fds"]) && isset($_GET["evento_id"])) {
    $eventoId = $_GET["evento_id"];
    
    $sqlEmpleados = mysqli_query($conexionBD, "SELECT *
    FROM evento
    INNER JOIN cronograma
    ON evento.id = cronograma.id_evento
    WHERE evento.id = $eventoId;");
    
    if (mysqli_num_rows($sqlEmpleados) > 0) {
        $empleados = mysqli_fetch_all($sqlEmpleados, MYSQLI_ASSOC);
        echo json_encode($empleados);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

//consultar por responsable
if (isset($_GET["cpr"]) && isset($_GET["responsable"])) {
    $eventoRes = $_GET["responsable"];
    
    // Usar consulta preparada para evitar problemas de seguridad y escape
    $stmt = $conexionBD->prepare("SELECT *
    FROM evento
    INNER JOIN cronograma
    ON evento.id = cronograma.id_evento
    WHERE evento.responsable = ?");
    
    // Vincular el valor del parámetro
    $stmt->bind_param("s", $eventoRes);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $empleados = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($empleados);
    } else {
        echo json_encode([["success" => 0]]);
    }
}


//consultar por objeto

if (isset($_GET["cpo"]) && isset($_GET["objeto"])) {
    $eventoRes = $_GET["objeto"];
    
    // Usar consulta preparada para evitar problemas de seguridad y escape
    $stmt = $conexionBD->prepare("SELECT *
    FROM evento
    INNER JOIN cronograma
    ON evento.id = cronograma.id_evento
    WHERE evento.objeto = ?");
    
    // Vincular el valor del parámetro
    $stmt->bind_param("s", $eventoRes);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $empleados = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($empleados);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

//consultar por estados
if (isset($_GET["cpes"]) && isset($_GET["estados"])) {
    $eventoRes = $_GET["estados"];
    
    // Usar consulta preparada para evitar problemas de seguridad y escape
    $stmt = $conexionBD->prepare("SELECT *
    FROM evento
    INNER JOIN cronograma
    ON evento.id = cronograma.id_evento
    WHERE cronograma.estado = ?");
    
    // Vincular el valor del parámetro
    $stmt->bind_param("s", $eventoRes);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $empleados = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($empleados);
    } else {
        echo json_encode([["success" => 0]]);
    }
}


?>