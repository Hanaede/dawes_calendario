<?php
// Variables para el mes y el año
$mes = 9;  // Por ejemplo, septiembre
$anio = 2024;

// Día actual
$diaActual = date('j'); // Obtiene el día actual (1-31)
$mesActual = date('n'); // Obtiene el mes actual (1-12)
$anioActual = date('Y'); // Obtiene el año actual

// Festivos (ejemplo: en formato de "día del mes" => "nombre del festivo")
$festivos = [
    1 => 'Día del Trabajador',   // Festivo el 1 de mayo
    25 => 'Navidad',             // Festivo el 25 de diciembre
    15 => 'Fiesta Nacional'      // Festivo el 15 de algún mes
];

// Obtenemos el número de días del mes
$diasEnMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

// Día de la semana en que comienza el mes (0 = domingo, 1 = lunes, etc.)
$primerDiaDelMes = date('w', strtotime("$anio-$mes-01"));

// Encabezados de los días de la semana
$diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Mensual</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            width: 14.28%; /* 100% dividido por 7 días */
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .hoy {
            background-color: green;
            color: white;
        }
        .festivo {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Calendario de <?= date('F Y', strtotime("$anio-$mes-01")) ?></h1>

    <table>
        <tr>
            <!-- Mostrar los nombres de los días de la semana -->
            <?php foreach ($diasSemana as $dia): ?>
                <th><?= $dia ?></th>
            <?php endforeach; ?>
        </tr>

        <tr>
            <!-- Agregar celdas vacías hasta el primer día del mes -->
            <?php for ($i = 0; $i < $primerDiaDelMes; $i++): ?>
                <td></td>
            <?php endfor; ?>

            <!-- Mostrar los días del mes -->
            <?php for ($dia = 1; $dia <= $diasEnMes; $dia++): ?>
                <?php
                // Clases CSS para los días especiales
                $clase = '';

                // Verificar si es el día actual
                if ($dia == $diaActual && $mes == $mesActual && $anio == $anioActual) {
                    $clase = 'hoy';
                }

                // Verificar si es un festivo
                if (isset($festivos[$dia])) {
                    $clase = 'festivo';
                }
                ?>

                <td class="<?= $clase ?>">
                    <?= $dia ?>
                </td>

                <!-- Saltar a la siguiente fila cuando sea sábado (día 6) -->
                <?php if (($dia + $primerDiaDelMes) % 7 == 0): ?>
                    </tr><tr>
                <?php endif; ?>

            <?php endfor; ?>

            <!-- Agregar celdas vacías al final si es necesario -->
            <?php while (($dia + $primerDiaDelMes - 1) % 7 != 0): ?>
                <td></td>
                <?php $dia++; ?>
            <?php endwhile; ?>
        </tr>
    </table>

</body>
</html>
