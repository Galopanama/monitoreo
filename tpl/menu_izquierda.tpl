<!-- Se configura el menu de la izquierda para todos los usuarios
Segun el "tipo de usuario", se presentara un resultado u otro
Desde esta pagina se direciona al usuario por los difereentes ficheros y funciones de FOMODI -->

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      {if $tipo_usuario === "administrador"}
        <ul class="nav flex-column"> INFORMATION
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="globe"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
             <ul>ORGANIZACIONES
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/" target="_blank">
                  <span data-feather="home"></span>
                  MCdP - Movimiento Coordinador de Panama
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TRANS
                </a>
              </li>
            </ul>
          </li> 
          GESTIONAR USUARIOS
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/admin/usuarios/index.php">
              <span data-feather="glyphicon glyphicon-search"></span>
              Usuarios
            </a>
          </li>
          OBSERVATIORIO DE ACTIVIDADES SEGUN LOS ACTORES
          <li>
            <ul class="nav flex-column">
              {* <li class="nav-item">
                <ul>
                  <li>
                  <a class="nav-link active" href="#"> 
                      <span data-feather="link"></span>
                      Subreceptor de poblacion HSH
                    </a>
                  </li>
                  <li>
                    <a class="nav-link active" href="#"> 
                      <span data-feather="link"></span>
                      Subreceptor de poblacion Trans
                    </a>
                  </li>
                  <li>
                    <a class="nav-link active" href="#"> 
                        <span data-feather="link"></span>
                        Subreceptor de poblacion TSF
                    </a>
                  </li>
                </ul>
              </li> *}
              <li class="nav-item">
                <a class="nav-link active" href="{$_WEB_PATH_}/admin/pruebas/pruebas.php">
                  <span data-feather="heart"></span>
                  Ver pruebas de los Tecnologos Medicos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{$_WEB_PATH_}/admin/entrevistas/individuales.php">
                  <span data-feather="user"></span>
                  Entrevistas Individuales de los Promotores 
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{$_WEB_PATH_}/admin/entrevistas/grupales.php">
                  <span data-feather="users"></span>
                  Actividades Grupales de los Promotores
                </a>
              </li>
            </ul>
          </li>
          VISUALIZAR DATOS
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/admin/resultados/personas_alcanzadas.php">
              <span data-feather="activity"></span>
              Grafica de l@s Alcanzad@s
            </a>
          </li>
          COMPARTIR 
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/" target="_blank">
              <span data-feather="folder-plus"></span>
              Transferencia de Archivos
            </a>
          </li>
        {else if $tipo_usuario === "subreceptor"}
        <ul class="nav flex-column"> INFORMACION
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="globe"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
          ORGANIZACIONES
            <ul> 
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/" target="_blank">
                  <span data-feather="home"></span>
                  MCdP - Movimiento Coordinador de Panama
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TRANS
                </a>
              </li>
            </ul>
          </li>
          VISUALIZAR DATOS
          <li class="nav-item"> 
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/individuales.php">
              <span data-feather="user"></span>
              Ver Entrevistas Individuales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/grupales.php">
              <span data-feather="users"></span>
              Ver Actividades Grupales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/pruebas/pruebas.php">
              <span data-feather="heart"></span>
              Ver Pruebas realizadas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/resultados/personas_alcanzadas.php">
              <span data-feather="pie-chart"></span>
              Ver Personas Alcanzadas
            </a>
          </li>
          {* <li class="nav-item">
            <a class="nav-link active" href=""> <!-- Esto lo he calzado por mi cuenta-->
              <span data-feather="activity"></span>
              Graficas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="columns"></span>
              Estadisticas
            </a>
          </li> *}
          COMPARTIR 
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/" target="_blank">
              <span data-feather="folder-plus"></span>
              Transferencia de Archivos
            </a>
          </li>
        </ul>
        {else if $tipo_usuario === "tecnologo"}
        <ul class="nav flex-column"> INFORMATION
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="globe"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
          ORGANIZACIONES
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/" target="_blank">
                  <span data-feather="home"></span>
                  MCdP - Movimiento Coordinador de Panama
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TRANS
                </a>
              </li>
            </ul>
          </li>
          INTRODUCIR DATOS
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/pruebas/addPrueba.php">
              <span data-feather="droplet"></span>
              Añadir Prueba
            </a>
          </li>
          VISUALIZAR DATOS
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/pruebas/pruebas.php">
              <span data-feather="heart"></span>
              Ver Pruebas
            </a>
          </li>
          {* <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="columns"></span>
              Estadisticas
            </a>
          </li> *}
          COMPARTIR
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/" target="_blank">
              <span data-feather="folder-plus"></span>
              Transferencia de Archivos
            </a>
          </li>
        {else if $tipo_usuario === "promotor"}
        <ul class="nav flex-column"> INFORMATION
          <li class="nav-item"> 
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="globe"></span>
              Proyecto global
            </a>
          </li>
          ORGANIZACIONES
          <li class="nav-item">
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/" target="_blank">
                  <span data-feather="home"></span>
                  MCdP - Movimiento Coordinador de Panama
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en" target="_blank">
                  <span data-feather="home"></span>
                  Subreceptor para poblacion TRANS
                </a>
              </li>
            </ul>
          </li>
          INTRODUCIR DATOS
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/addIndividual.php">
              <span data-feather="user"></span>
              Añadir Entrevista Individual
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/addGrupal.php">
              <span data-feather="users"></span>
              Añadir Actividad Grupal
            </a>
          </li>
          VISUALIZAR DATOS
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/individuales.php">
              <span data-feather="user-check"></span>
              Ver Entrevistas Individuales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/grupales.php">
              <span data-feather="user-plus"></span>
              Ver Entrevistas Grupales
            </a>
          </li>
          {* <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="activity"></span>
              Graficas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="columns"></span>
              Estadisticas
            </a>
          </li> *}
          COMPARTIR
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/" target="_blank">
              <span data-feather="folder-plus"></span>
              Transferencia de Archivos
            </a>
          </li>
        </ul>
      {/if}
    </ul>
  </div>
</nav>