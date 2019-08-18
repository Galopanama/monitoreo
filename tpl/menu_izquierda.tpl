<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      {if $tipo_usuario === "administrador"}
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="home"></span>
              Proyecto Global
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="briefcase"></span>
              Organizaciones
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
                <a class="nav-link active" href="#">
                  <span data-feather="heart"></span>
                  Tecnologo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="bookmark"></span>
                  Promotor
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
              Tablas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="cpu"></span>
              Recursos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="facebook"></span>
              Social Media
            </a>
          </li>
        {/if}
      </ul>
    </ul>
  </div>
</nav>