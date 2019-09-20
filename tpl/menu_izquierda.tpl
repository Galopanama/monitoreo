<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      {if $tipo_usuario === "administrador"}
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="home"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/">
                  <span data-feather="briefcase"></span>
                  MCdP
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/">
                  <span data-feather="briefcase"></span>
                  Org - HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/">
                  <span data-feather="briefcase"></span>
                  Org - TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en">
                  <span data-feather="briefcase"></span>
                  Org - TRANS
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
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
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/
            ">
              <span data-feather="document"></span>
              Transferencia de Archivos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="facebook"></span>
              Social Media
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="document"></span>
              Contactos Utiles
            </a>
          </li>
          <li>Observatorio de actividades segun
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#"> <!-- en enlace desde aqui se hace con un fichero que 
              traiga la informacion a modo de array ?-->
                  <span data-feather="at-sign"></span>
                  Subreceptor
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{$_WEB_PATH_}/admin/pruebas/pruebas.php">
                  <span data-feather="heart"></span>
                  Tecnologo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{$_WEB_PATH_}/admin/entrevistas/individuales.php">
                  <span data-feather="bookmark"></span>
                  Entrevistas Individuales del Promotor 
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{$_WEB_PATH_}/admin/entrevistas/grupales.php">
                  <span data-feather="bookmark"></span>
                  Actividades Grupales
                </a>
              </li>
            </ul>
          </li>
        {else if $tipo_usuario === "subreceptor"}
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="home"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/">
                  <span data-feather="briefcase"></span>
                  MCdP
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/">
                  <span data-feather="briefcase"></span>
                  Org - HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/">
                  <span data-feather="briefcase"></span>
                  Org - TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en">
                  <span data-feather="briefcase"></span>
                  Org - TRANS
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/individuales.php">
              <span data-feather="columns"></span>
              Ver Entrevistas Individuales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/grupales.php">
              <span data-feather="columns"></span>
              Ver Entrevistas Grupales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="">
              <span data-feather="droplet"></span>
              Tecnologo
            </a>
          </li>
          <li class="nav-item">
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
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/
            ">
              <span data-feather="document"></span>
              Transferencia de Archivos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="facebook"></span>
              Social Media
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="document"></span>
              Contactos Utiles
            </a>
          </li>
        </ul>
        {else if $tipo_usuario === "tecnologo"}
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="home"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/">
                  <span data-feather="briefcase"></span>
                  MCdP
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/">
                  <span data-feather="briefcase"></span>
                  Org - HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/">
                  <span data-feather="briefcase"></span>
                  Org - TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en">
                  <span data-feather="briefcase"></span>
                  Org - TRANS
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/pruebas/pruebas.php">
              <span class="fi-beaker"></span>
              Ver Pruebas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/pruebas/addPrueba.php">
              <span data-feather="droplet"></span>
              Añadir Prueba
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/pruebas/pruebas.php">
              <span data-feather="droplet"></span>
              Ver Pruebas
            </a>
          </li>
          <li class="nav-item">
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
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/
            ">
              <span data-feather="document"></span>
              Transferencia de Archivos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="facebook"></span>
              Social Media
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="document"></span>
              Contactos Utiles
            </a>
          </li>
        {else if $tipo_usuario === "promotor"}
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/documentos/PresentaciónProyecto/index.html">
              <span data-feather="home"></span>
              Proyecto global
            </a>
          </li>
          <li class="nav-item">
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="https://www.facebook.com/MCdPma/">
                  <span data-feather="briefcase"></span>
                  MCdP
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://www.facebook.com/AHMNPLGBT/">
                  <span data-feather="briefcase"></span>
                  Org - HSH
                </a>
              </li>
              <li>            
                <a class="nav-link active" href="https://www.facebook.com/viviendo.positivamente/">
                  <span data-feather="briefcase"></span>
                  Org - TSF
                </a>
              </li>
              <li>
                <a class="nav-link active" href="https://twitter.com/apptranspanama?lang=en">
                  <span data-feather="briefcase"></span>
                  Org - TRANS
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/addIndividual.php">
              <span data-feather="person"></span>
              Añadir Entrevista Individual
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/addGrupal.php">
              <span data-feather="people"></span>
               Añadir Actividad Grupal
            </a>
          </li>
          <li class="nav-item">
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
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/individuales.php">
              <span data-feather="columns"></span>
              Ver Entrevistas Individuales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{$_WEB_PATH_}/user/entrevistas/grupales.php">
              <span data-feather="columns"></span>
              Ver Entrevistas Grupales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="https://ydray.com/
            ">
              <span data-feather="document"></span>
              Transferencia de Archivos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="facebook"></span>
              Social Media
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="document"></span>
              Contactos Utiles
            </a>
          </li>
        </ul>
        {/if}
      </ul>
    </ul>
  </div>
</nav>