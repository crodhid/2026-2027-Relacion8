<?php
include_once(dirname(__FILE__) . "/../../../cabecera.php");

mb_internal_encoding("UTF-8");

// ---- Controlador ----
$ubicacion = [
    "pagina principal" => "../../../index.php",
    "personalizar" => "./index.php"
];

// Contador de visitas (cookie). Antes de cualquier salida HTML.
$visitas = $_COOKIE["visitas"] ?? 0;
$visitas = (is_string($visitas) && ctype_digit($visitas)) ? (int) $visitas : 0;
$visitas++;
setcookie("visitas", (string) $visitas, time() + 60 * 60 * 24 * 365, "/");

// Colores configurados los cuales extraemos de mi función en cabecera, que me devuelve las cookies con mis colores fijados
[$fondoSel, $textoSel] = colorActual();
$fondoCss = COLORESFONDO[$fondoSel];
$textoCss = COLORESTEXTO[$textoSel];



// ---- Dibujar la plantilla ----
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera($fondoCss, $textoCss);
finCabecera();
inicioCuerpo("PERSONALIZAR", $ubicacion);
cuerpo($visitas);
finCuerpo();

// ---- Vistas ----
function cabecera(string $fondoCss, string $textoCss)
{
    echo "<style>body #documento { background-color: $fondoCss; color: $textoCss; }</style>";
}

function cuerpo(int $visitas)
{
    ?>
    <h2>Información</h2>
    <p>Esta es una página de ejemplo que se visualiza con los colores que has configurado.</p>
    <p>Has accedido a esta página <?php echo $visitas; ?> veces.</p>
    <p><a href="personalizar.php">Cambiar colores</a></p>
    <?php
}