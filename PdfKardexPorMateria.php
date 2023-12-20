<?php
include_once "funciones.php";
conectarDB();
require_once('tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener los parámetros de la URL
    $nombre_materia = $_GET["Materia"];
    $clave_materia = $_GET["Clave_Materia"];
    $ciclo_escolar = $_GET["Ciclo_Escolar"];
    $semestre = $_GET["Semestre"];
    $grupo = $_GET["Grupo"];
    // Imprimir variables en el log de errores
    generarPDFCalificacionesMateria($clave_materia, $ciclo_escolar, $semestre, $grupo, $nombre_materia );
    exit;
}

include('funciones.php');
// Puedes agregar un formulario aquí si necesitas algún parámetro adicional

// Si no se ha enviado una fecha, muestra el formulario
?>
<!DOCTYPE html>
<html>

<head>
    <title>Calificaciones por Materia</title>
</head>

<body>
    <h1>Calificaciones por Materia</h1>
    <!-- Puedes agregar un formulario aquí si necesitas algún parámetro adicional -->
</body>

</html>

<?php
//Generar Calificaciones por Materia
function generarPDFCalificacionesMateria($clave_materia, $ciclo_escolar, $semestre, $grupo, $nombre_materia) {
    // Obtener información del alumno y sus calificaciones
    $conexion = conectarDB();
    $sql = "SELECT A.Matricula, A.Nombre, A.Apellido, C.Calificacion 
    FROM CURSAR C 
    INNER JOIN ALUMNOS A ON C.Matricula_Alumno = A.Matricula 
    INNER JOIN MATERIAS M ON C.Clave_Materia = M.Clave 
    WHERE A.Semestre = :semestre AND A.Grupo = :grupo 
        AND M.Clave = :clave_materia AND C.Ciclo_Escolar = :ciclo_escolar
    ORDER BY A.Apellido ASC;";

    $statement = $conexion->prepare($sql);
    $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':clave_materia', $clave_materia, PDO::PARAM_STR);
    $statement->bindParam(':ciclo_escolar', $ciclo_escolar, PDO::PARAM_STR);
    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo "<p>No se encontraron calificaciones para la materia seleccionada.</p>";
        return;
    }

    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    $pdf->SetFont('Helvetica', '', 11);
    // Logo de la UABJO en el lado izquierdo superior
    $pdf->Image('iconos/UBAJOLOGOCONFONDO.jpg', 10, 7, 20, '', 'JPG');
    // Logo de la FCQ en el lado derecho superior
    $pdf->Image('iconos/FCQLOGOCONFONDO.jpg', 180, 7, 20, '', 'JPG');
    // Título de la Universidad en el centro
    $pdf->Cell(0, 10, "UNIVERSIDAD AUTÓNOMA \"BENITO JUÁREZ\" DE OAXACA", 0, 1, 'C');
    $pdf->Image('iconos/Adorno.png', 45, 18, 120, '', 'PNG');

    // Subtítulo de la Facultad centrado y más pequeño
    $pdf->SetFont('Helvetica', 'B', 10);
    
    $pdf->Cell(0, 8, "FACULTAD DE CIENCIAS QUÍMICAS", 0, 1, 'C');

    $pdf->Cell(0, 7, "$nombre_materia, Calificaciones $semestre $grupo Ciclo Escolar: $ciclo_escolar", 0, 1, 'C');
    //$titulo = ;

    // Agregar espacio antes de la tabla
    $pdf->Cell(0, 5, "", 0, 1);



// Calcular la posición x para centrar la tabla horizontalmente
$tableWidth = 40 + 60 + 40; // Suma de los anchos de las celdas
$tableX = ($pdf->getPageWidth() - $tableWidth) / 2;

// Tabla de calificaciones
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->SetXY($tableX, $pdf->GetY()); // Establecer posición x
$pdf->Cell(40, 7, "Matrícula", 1);
$pdf->Cell(60, 7, "Nombre", 1);
$pdf->Cell(40, 7, "Calificación", 1);
$pdf->Ln();

$pdf->SetFont('Helvetica', '', 8);
// Detalles de las calificaciones
foreach ($resultado as $fila) {
    $pdf->SetX($tableX); // Establecer posición x para cada fila
    $pdf->Cell(40, 5, $fila['Matricula'], 1);
    //$pdf->Cell(60, 5, $fila['Nombre'] . ' ' . $fila['Apellido'], 1);
    $pdf->Cell(60, 5, $fila['Apellido']. ' ' . $fila['Nombre'] , 1);
    $pdf->Cell(40, 5, $fila['Calificacion'], 1);
    $pdf->Ln();
}
// Espacios para firmas

// Espacios para firmas
$pdf->Ln(20);
$pdf->Cell(75, 5, " ", 0, 0);
$pdf->Cell(80, 5, " ___________________________", 0, 1);
$pdf->Cell(95, 5, " ", 0, 0);
$pdf->Cell(80, 5, "Firma", 0, 1);

// Obtener la fecha y hora actual
$fecha_actual = date("d/m/Y H:i:s");

// Agregar el mensaje al final del PDF
$pdf->Ln(5);
$pdf->Cell(40, 10, "Generado el $fecha_actual.", 0, 1, 'C');






    // Mostrar el PDF en el navegador
    ob_end_clean(); // Limpiar cualquier salida de buffer anterior
    $pdf->Output("Calificaciones_Materia_$clave_materia.pdf", 'I');
    exit;
}
?>
