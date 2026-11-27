<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

mb_internal_encoding("UTF-8");

// ---- Controlador ----
$ubicacion = [
    "pagina principal" => "/index.php",
    "verTextos" => "/aplicacion/texto/verTextos.php"
];

[$fondoSel, $textoSel] = colorActual();
$fondoCss = COLORESFONDO[$fondoSel];
$textoCss = COLORESTEXTO[$textoSel];

/**
 * Recojo los textos de la sesión.
 * Como tenemos la autocarga en cabecera simplemente se guarda en la sesión ya siempre
 * estamos comprobando que sesion de textos no esta vacío y que es un array
 */
$textosGuardados = [];
if (isset($_SESSION["textos"]) && is_array($_SESSION["textos"])) {
    $textosGuardados = $_SESSION["textos"];
}

/**
 * Guardar: añado el objeto al array y actualizo la sesión
 */
if (isset($_POST["guardar"]) && trim($_POST["texto"] ?? "") !== "") {
    // Cada vez que guardo, el objeto va a una posición distinta del array
    $textosGuardados[] = new RegistroTexto(trim($_POST["texto"]));
    // Actualizo la sesión con el array entero
    $_SESSION["textos"] = $textosGuardados;
}

/**
 * Limpiar: vacío los textos en la sesión, pero NO destruyo la sesión
 */
if (isset($_POST["limpiar"])) {
    $textosGuardados = [];
    $_SESSION["textos"] = $textosGuardados;
}

// ---- Dibujar la plantilla ----
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera($fondoCss, $textoCss);
finCabecera();
inicioCuerpo("TEXTOS GUARDADOS", $ubicacion);
cuerpo($textosGuardados);
finCuerpo();

// ---- Vistas ----
function cabecera(string $fondoCss, string $textoCss)
{
    echo "<style>body #documento { background-color: $fondoCss; color: $textoCss; }</style>";
}

function cuerpo(array $textosGuardados)
{
    echo formulario();
    echo pintarTextArea($textosGuardados);
}

function formulario(): string
{
    ob_start();
?>
    <form method="post" action="">
        <label for="texto">Texto a guardar</label>
        <input type="text" name="texto" id="texto">
        <br>
        <button name="guardar">Guardar Texto</button>
        <button name="limpiar">Limpiar</button>
    </form>
<?php
    return ob_get_clean();
}

function pintarTextArea(array $textosGuardados): string
{
    ob_start();
?>
    <textarea rows="10" cols="60" readonly><?php
        foreach ($textosGuardados as $registro) {
            echo $registro->getFechaYHora() . " - " . $registro->getCadena() . "\n";
        }
    ?></textarea>
<?php
    return ob_get_clean();
}