<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
  <a class="dashboard__boton" href="/admin/eventos/crear">
    <i class="fa-solid fa-circle-plus"></i>
    &ThickSpace;Añadir Evento
  </a>
</div>

<div class="dashboard__contenedor">
  <?php if(!empty($eventos)) : ?>
    <table class="table">
      <thead class="table__thead">
        <tr>
          <th scope="col" class="table__th">Evento</th>
          <th scope="col" class="table__th">Categoría</th>
          <th scope="col" class="table__th">Día y Hora</th>
          <th scope="col" class="table__th">Ponente</th>
          <th scope="col" class="table__th"></th>
        </tr>
      </thead>
      <tbody class="table__tbody">
        <?php foreach($eventos as $evento) : ?>
          <tr class="table__tr">
            <td class="table__td"><?php echo $evento->nombre; ?></td>
            <td class="table__td"><?php echo $evento->categoria_id; ?></td>
            <td class="table__td"><?php echo $evento->dia_id; ?></td>
            <td class="table__td"><?php echo $evento->ponente_id; ?></td>
            
            <td class="table__td--acciones">
              <a class="table__accion table__accion--editar" href="/admin/ponentes/editar?id=<?php echo $ponente->id; ?>">
                <i class="fa-solid fa-user-pen"></i>&ThickSpace;Editar
              </a>
              <form method="POST" action="/admin/ponentes/eliminar" class="table__formulario">
                <input type="hidden" name="id" value="<?php echo $evento->id; ?>">
                <button class="table__accion table__accion--eliminar" type="submit">
                  <i class="fa-solid fa-circle-xmark"></i>&ThickSpace;Eliminar
                </button>
              </form>
            </td><!--.table__td--acciones-->
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else : ?>
    <p class="text-center">No Hay Eventos Aún</p>
  <?php endif; ?>

  <?php echo $paginacion; ?>

</div>