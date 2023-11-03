<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
  <div class="navbar-vertical-content scrollbar">
    <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
      <li class="nav-item">
        <a class="nav-link" href="listado_profesores" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="far fa-list-alt"></span> </span><span class="nav-link-text ps-1">Docentes</span>
          </div>
        </a>
        <a class="nav-link" href="listado_centros" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-warehouse"></span> </span><span class="nav-link-text ps-1">Centros</span>
          </div>
        </a>
        <a class="nav-link" href="listado_alumnos" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user"></span> </span><span class="nav-link-text ps-1">Alumnos</span>
          </div>
        </a>
        <a class="nav-link" href="listado_niveles" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas far fa-chart-bar"></span> </span><span class="nav-link-text ps-1">Niveles</span>
          </div>
        </a>
        <a class="nav-link" href="listado_cursos" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas far fa-address-book"></span> </span><span class="nav-link-text ps-1">Cursos</span>
          </div>
        </a>
        <a class="nav-link" href="listado_grupos" role="button" data-bs-toggle="" aria-expanded="false">
          <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas far fa-address-card"></span> </span><span class="nav-link-text ps-1">Grupos</span>
          </div>
        </a>
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