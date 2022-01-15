<?php include_once 'includes/layout/header.php'; ?>
<?php include_once 'includes/funciones/funciones.php' ?>

<div class="contenedor-barra">
  <h1>Agenda de Contactos</h1>
</div>

<div class="contenedor bg-amarillo sombra">
  <form action="#" id="contacto">
    <legend>Añada un contacto<span>Todos los campos son obligatorios</span></legend>

    <?php include_once 'includes/layout/formulario.php'; ?>
  </form>
</div>

<div class="bg-blanco contenedor sombra contactos">
  <div class="contenedor-contactos">
    <h2>Contactos</h2>

    <input type="text" name="buscar" id="buscar" class="buscador" placeholder="Buscar Contactos...">

    <p class="total-contactos"><span></span> Contactos</p>

    <div class="contenedor-tabla">
      <table id="listado-contactos" class="listado-contactos">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Empresa</th>
            <th>Telefono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $contactos = getContactos();
          if ($contactos->num_rows) :
            foreach ($contactos as $contacto) : ?>
              <tr>
                <td><?= $contacto['nombre'] ?></td>
                <td><?= $contacto['empresa']  ?></td>
                <td><?= $contacto['telefono'] ?></td>
                <td>
                  <a href="editar.php?id=<?= $contacto['id'] ?>" class="btn-editar boton"><i class="fas fa-pen-square"></i></a>
                  <button type="button" class="btn-borrar boton" data-id=<?= $contacto['id'] ?>><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>
          <?php
            endforeach;
          endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<?php include_once 'includes/layout/footer.php'; ?>