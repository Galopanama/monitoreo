<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Personas Alcanzadas</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
  </div>
</div>

<div class="alert alert-danger d-none" role="alert">
  <p>{$error}</p>
</div>

<div class="alert alert-success d-none" role="alert">
  <h4 class="alert-heading">{$exito_titulo}</h4>
  <p>{$exito_mensaje}</p>
</div>

<table id="alcanzados" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Cedula de la persona receptora</th>
            <th>Fecha cuando fue alcanzado</th>
            <th>Region de Salud</th>
            <th>Poblacion Originaria</th>
            <th>Poblacion</th>
            <th>Fecha cuando se introduce al sistema</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Cedula de la persona receptora</th>
            <th>Fecha cuando fue alcanzado</th>
            <th>Region de Salud</th>
            <th>Poblacion Originaria</th>
            <th>Poblacion</th>
            <th>Fecha cuando se introduce al sistema</th>
        </tr>
    </tfoot>
</table>

<!-- Ahora bien... se podria hacer una union de las tablas de modo que queden campos de ambas asi juntas -->