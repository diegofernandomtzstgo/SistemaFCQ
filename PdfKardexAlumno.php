<?php
include_once "funciones.php";
conectarDB();
require_once('tcpdf/tcpdf.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero_matricula = $_POST["matricula"];
    $ciclo_escolar = $_POST["ciclo_escolar"];
    generarPDFKardex($numero_matricula, $ciclo_escolar);
    exit;
}

function generarPDFKardex($numero_matricula, $ciclo_escolar) {
    // Obtener información del alumno y sus calificaciones
    $conexion = conectarDB();
    $sql = "SELECT a.Matricula, a.Nombre, a.Apellido, a.Semestre, a.Grupo, m.Clave, m.Nombre as Materia, c.Calificacion, f.Nombre as Carrera 
                FROM alumnos a 
                INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno 
                INNER JOIN materias m ON c.Clave_Materia = m.Clave 
                INNER JOIN formacion f ON m.ClaveFormacion = f.Clave 
                WHERE a.Matricula = :matricula AND c.Ciclo_Escolar = :ciclo_escolar";

        $statement = $conexion->prepare($sql);
        $statement->bindParam(':matricula', $numero_matricula, PDO::PARAM_INT);
        $statement->bindParam(':ciclo_escolar', $ciclo_escolar, PDO::PARAM_STR);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo "<p>No se encontraron calificaciones para el alumno.</p>";
        return;
    }

    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    // Agregar contenido al PDF (puedes personalizar esto según tus necesidades)
    $pdf->SetFont('Helvetica', '', 11);

    // Logo de la UABJO en el lado izquierdo superior
    $pdf->Image('iconos/UBAJOLOGOCONFONDO.jpg', 10, 2, 30, '', 'JPG');

    
    
    
    // Logo de la FCQ en el lado derecho superior
    $pdf->Image('iconos/FCQLOGOCONFONDO.jpg', 170, 4, 30, '', 'JPG');
  
    

    // Título de la Universidad en el centro
    
    $pdf->Cell(0, 10, "UNIVERSIDAD AUTÓNOMA \"BENITO JUÁREZ\" DE OAXACA", 0, 1, 'C');

    
    
    // Subtítulo de la Facultad centrado y más pequeño
    $pdf->SetFont('Helvetica', 'B', 10);
    
    $pdf->Cell(0, 8, "FACULTAD DE CIENCIAS QUÍMICAS", 0, 1, 'C');

    $pdf->Cell(0, 7, "Kardex de Calificaciones", 0, 1, 'C');

    // Agregar espacio antes de la foto
    $pdf->Cell(0, 5, "", 0, 1);

// Definir el tamaño del cuadro para la foto infantil
$tamano_cuadro_ancho = 25;
$tamano_cuadro_alto = 30;

$posicion_x = 10;
$posicion_y = $pdf->GetY();

// Dibujar el rectángulo para la foto infantil
$pdf->Rect($posicion_x, $posicion_y, $tamano_cuadro_ancho, $tamano_cuadro_alto, 'D');

// Calcular la posición Y para la información (más arriba, pero sin superponerse con el cuadro)
$posicion_y_info = max($posicion_y, $pdf->GetY() - 10);

$pdf->SetY($posicion_y_info);

// Configurar la posición X para los datos del alumno
$posicion_x_datos_alumno = $posicion_x + $tamano_cuadro_ancho + 10;

$pdf->SetX($posicion_x_datos_alumno);

$pdf->SetFont('Helvetica', '', 10);
$fila_alumno = $resultado[0];

$pdf->Cell(0, 5, "", 0, 10);

// Agregar datos del alumno al lado del rectángulo
$pdf->Cell(20, 5, "Matrícula:", 0, 0, 'B');
$pdf->Cell(42, 5, $fila_alumno['Matricula'], 0, 0);
$pdf->Cell(23, 5, "Nombre:", 0, 0, 'B');
$pdf->Cell(60, 5, $fila_alumno['Nombre'] . ' ' . $fila_alumno['Apellido'], 0, 1);

// Configurar la posición X para las siguientes celdas
$pdf->SetX($posicion_x_datos_alumno);

$pdf->Cell(20, 5, "Carrera:", 0, 0, 'B');
$pdf->Cell(42, 5, $fila_alumno['Carrera'], 0, 0);
$pdf->Cell(23, 5, "Ciclo Escolar:", 0, 0, 'B');
$pdf->Cell(60, 5, $ciclo_escolar, 0, 1);

// Configurar la posición X para las siguientes celdas
$pdf->SetX($posicion_x_datos_alumno);

$pdf->Cell(20, 5, "Semestre:", 0, 0, 'B');
$pdf->Cell(42, 5, $fila_alumno['Semestre'], 0, 0);
$pdf->Cell(23, 5, "Grupo:", 0, 0, 'B');
$pdf->Cell(60, 5, $fila_alumno['Grupo'], 0, 1);

$pdf->Cell(0, 7, "", 0, 1); // Agregar espacio

    // Tabla de calificaciones
    $pdf->Cell(0, 10, "", 0, 1); // Agregar espacio
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Cell(60, 7, "Clave de Materia", 1);
    $pdf->Cell(60, 7, "Nombre de Materia", 1);//1 ES PARA MARGEN DE LAS TABLAS
    $pdf->Cell(60, 7, "Calificación", 1);
    $pdf->Ln();

    $pdf->SetFont('Helvetica', 8);
    // Detalles de las calificaciones
    foreach ($resultado as $fila_materia) {
        $pdf->Cell(60, 5, $fila_materia['Clave'], 1);
        $pdf->Cell(60, 5, $fila_materia['Materia'], 1);
        $pdf->Cell(60, 5, $fila_materia['Calificacion'], 1);
        $pdf->Ln();
    }
    // Espacios para firmas
    $pdf->Ln(10);
    $pdf->Cell(80, 5, " ___________________________", 0, 0);
    $pdf->Cell(80, 5, " ___________________________", 0, 1);
    $pdf->Cell(90, 5, "       Coordinador Académico ", 0, 0);
    $pdf->Cell(80, 5, "              Director", 0, 1);
    $pdf->Cell(80, 5, "M. en C. Antonio Canseco Urbieta ", 0, 0);
    $pdf->Cell(80, 5, "DR. en C. Juan Luis Bautista Martínez Martinez", 0, 1);
    // Mostrar el PDF en el navegador
    ob_end_clean(); // Limpiar cualquier salida de buffer anterior
    $pdf->Output("Kardex_Alumno_$numero_matricula.pdf", 'I');
    exit;
}

// Si no se ha enviado una fecha, muestra el formulario
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kardex de Calificaciones</title>
</head>

<body>
    <h1>Kardex de Calificaciones</h1>
    <!-- Puedes agregar un formulario aquí si necesitas algún parámetro adicional -->
</body>

</html>
