<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
  <div class="navbar-vertical-content scrollbar">
    <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
      <li class="nav-item">
        <a class="nav-link" href="listado_ots" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="far fa-list-alt"></span> </span><span class="nav-link-text ps-1">OTS</span>
          </div>
        </a>
      </li>


      <li class="nav-item">
        <!-- label-->
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
          <div class="col-auto navbar-vertical-label">Utilidades
          </div>
          <div class="col ps-0">
            <hr class="mb-0 navbar-vertical-divider" />
          </div>
        </div>
        <a class="nav-link dropdown-indicator" href="#user" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="user">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-wrench"></span></span><span class="nav-link-text ps-1">Configuración</span>
          </div>
        </a>
        <ul class="nav collapse" id="user">
          <li class="nav-item"><a class="nav-link" href="listado_trabajadores" data-bs-toggle="" aria-expanded="false">
              <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Trabajadores</span>
              </div>
            </a>

          </li>
          <li class="nav-item"><a class="nav-link" href="listado_clientes" data-bs-toggle="" aria-expanded="false">
              <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Clientes</span>
              </div>
            </a>

          </li>
          <li class="nav-item"><a class="nav-link" href="listado_logs" data-bs-toggle="" aria-expanded="false">
              <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Log acceso</span>
              </div>
            </a>

          </li>

        </ul>

      </li>
    </ul>
  </div>
</div>

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script type="text/javascript">
  const getPage = (url = '') => {
    const [linkLastPathUrl] = url?.split('/')?.slice(-1) ?? [];
    const [linkPage] = linkLastPathUrl?.split('?') ?? [];
    return linkPage ?? null;
  };

  const page = getPage(document.location.href);

  (document.querySelectorAll('a') ?? []).forEach(link => {
    const linkPage = getPage(link?.href);

    if (page === linkPage) {
      link?.classList?.add('active');
      const ul = link?.closest('ul');
      const {
        id: ulId
      } = ul ?? {};

      if (ul && ulId) {
        document.querySelector(`li:has(#${ulId}) > a`)?.setAttribute('aria-expanded', true);
        ul?.classList.add('show');
      }
    }
  });
</script>

<!-- <a class="nav-link dropdown-indicator" href="#events" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-wrench"></span></span><span class="nav-link-text ps-1">Configuración</span>
          </div>
        </a>
        <ul class="nav collapse" id="events">
          <li class="nav-item"><a class="nav-link" href="listado_trabajadores" data-bs-toggle="" aria-expanded="false">
              <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Trabajadores</span>
              </div>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="listado_clientes" data-bs-toggle="" aria-expanded="false">
              <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Clientes</span>
              </div>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="listado_logs" data-bs-toggle="" aria-expanded="false">
              <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Logs</span>
              </div>
            </a>
          </li>

        </ul> -->