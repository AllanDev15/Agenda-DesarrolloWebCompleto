<?php 
    include 'includes/funciones/funciones.php';
    include_once 'includes/layout/header.php'; 
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Convierte el valor a int

    if(!$id) {
        die('No es valido');
    }

    $resultado = getContacto($id);
    $contacto = $resultado->fetch_assoc();
?>

<div class="contenedor-barra">            
        <div class="contenedor barra">
            <a href="index.php" class="boton volver">Volver</a>
            <h1>Editar Contacto</h1>
        </div>
</div>

<div class="contenedor bg-amarillo sombra">
    <form action="#" id="contacto" >
        <legend>Edite el contacto</legend>

        
        <?php include_once 'includes/layout/formulario.php'; ?>


    </form>
</div>

<?php include_once 'includes/layout/footer.php'; ?>