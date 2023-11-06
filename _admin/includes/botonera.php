<?php
$logo = $_SESSION['logo'];
?>

<style>
  .img {
    width: 6rem;
    height: 3rem;
    object-fit: cover;
  }
</style>

<script>
  var isFluid = JSON.parse(localStorage.getItem('isFluid'));
  if (isFluid) {
    var container = document.querySelector('[data-layout]');
    container.classList.remove('container');
    container.classList.add('container-fluid');
  }
</script>
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
  <script>
    var navbarStyle = localStorage.getItem("navbarStyle");
    if (navbarStyle && navbarStyle !== 'transparent') {
      document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
    }
  </script>

  <div class="d-flex align-items-center">
    <div class="toggle-icon-wrapper">

      <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Ocultar menú">
        <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
      </button>

    </div><a class="navbar-brand" href="listado_ots">
      <div class="d-flex align-items-center py-3"><img class="me-2 img" src="<?php echo $logo ?>" alt="" width="100" />
      </div>
    </a>
  </div>