<fieldset class="formulario__fieldset">
  <legend class="formulario__legend">Información Evento</legend>

  <div class="formulario__campo">
    <label for="nombre" class="formulario__label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="formulario__input" placeholder="Nombre Evento" value="<?php echo $evento->nombre; ?>" />
  </div>

  <div class="formulario__campo">
    <label for="descripcion" class="formulario__label">Descripción</label>
    <textarea name="descripcion" id="descripcion" class="formulario__input" placeholder="Descripción Evento" rows="10"><?php echo $evento->descripcion; ?></textarea>
  </div>

  <div class="formulario__campo">
    <label for="categoria" class="formulario__label">Categoría</label>
    <select name="categoria_id" id="categoria" class="formulario__select">
      <option value="" disabled class="formulario__option">&mdash;&ThickSpace;Seleccionar&ThickSpace;&mdash;</option>
      <?php foreach($categorias as $categoria) : ?>
        <?php if($evento->categoria_id === $categoria->id): ?>
          <option value="<?php echo $categoria->id; ?>" class="formulario__option" selected><?php echo $categoria->nombre; ?></option>
        <?php elseif($evento->categoria_id !== $categoria->id) : ?>
          <option value="<?php echo $categoria->id; ?>" class="formulario__option"><?php echo $categoria->nombre; ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
  </div>
  
  <div class="formulario__campo">
    <label for="dia" class="formulario__label">Seleccionar día</label>
    <div class="formulario__radio">
      <?php foreach($dias as $dia) : ?>
        <div>
          <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>
          <input type="radio" class="formulario__input" id="<?php echo strtolower($dia->nombre); ?>" name="dia" value="<?php echo $dia->id; ?>" />
        </div>
      <?php endforeach; ?>
    </div>
    <input type="hidden" name="dia_id" value="">
  </div>

  <div class="formulario__campo">
    <label for="hora" class="formulario__label">Seleccionar Hora</label>
    <ul class="horas" id="horas">
      <?php foreach($horas as $hora) : ?>
        <li data-hora-id="<?php echo $hora->id?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
      <?php endforeach; ?>
    </ul>
    <input type="hidden" name="hora_id" value="">
  </div>
</fieldset>

<fieldset class="formulario__fieldset">
  <legend class="formulario__legend">Información Extra</legend>

  <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Ponente</label>
        <input type="text" class="formulario__input" id="ponentes" name="ponentes" placeholder="Buscar Ponente" />
        <ul id="listado-ponentes" class="listado-ponentes"></ul>
        <input type="hidden" name="ponente_id" value="">
  </div>

  <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Tickets Disponibles</label>
        <input type="number" class="formulario__input" id="disponibles" name="disponibles" min="1" max="99" placeholder="Ej: 20" value="<?php echo $evento->disponibles; ?>" />
  </div>

</fieldset>