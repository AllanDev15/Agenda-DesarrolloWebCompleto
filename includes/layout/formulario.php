<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text" 
            name="nombre" 
            id="nombre" 
            placeholder="Nombre de Contacto"
            value="<?= ($contacto['nombre']) ? $contacto['nombre'] : '' ?>">
    </div>

    <div class="campo">
        <label for="empresa">Empresa:</label>
        <input 
            type="text" 
            name="empresa" 
            id="empresa" 
            placeholder="Nombre de Empresa"
            value="<?= ($contacto['empresa']) ? $contacto['empresa'] : '' ?>">
    </div>

    <div class="campo">
        <label for="telefono">Telefono:</label>
        <input 
            type="tel" 
            name="telefono" 
            id="telefono" 
            placeholder="Telefono de Contacto"
            value="<?= ($contacto['telefono']) ? $contacto['telefono'] : '' ?>">
    </div>

</div>
<div class="campo enviar">
    <?php 
    $textoBtn = ($contacto['telefono']) ? 'Guardar' : 'Añadir'; 
    $accion = ($contacto['telefono']) ? 'editar' : 'crear';
    ?>
    <input type="hidden" id="accion"  value="<?= $accion ?>">
    <?php if(isset($contacto['id'])): ?>
        <input type="hidden" id="id"  value="<?= $contacto['id'] ?>">
    <?php endif; ?>
    <input type="submit" value="<?= $textoBtn ?>">
</div>