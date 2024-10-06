<h2 class="dashboard__heading"><?php echo $ponente->nombre . " " . $ponente->apellido; ?></h2>

<div class="dashboard__contenedor-boton">
  <a class="dashboard__boton" href="/admin/ponentes">
    <i class="fa-solid fa-circle-arrow-left dashboard__icono"></i>
    &ThickSpace;Volver
  </a>
</div>

<div class="dashboard__formulario">
  <?php
    include_once __DIR__ . '/../../templates/alertas.php';
  ?>
  
  <form method="POST" enctype="multipart/form-data" class="formulario">

    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" value="Actualizar" class="formulario__submit formulario__submit--registrar">
  </form>
</div>