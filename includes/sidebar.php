
<!-- Offcanvas for Mobile -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <?php include('includes/sidebar-content.php'); ?>
  </div>
</div>

<!-- Sidebar for Desktop -->
<nav class="col-lg-2 d-none d-lg-block sidebar">
  <div class="h-100">
    <?php include('includes/sidebar-content.php'); ?>
  </div>
</nav>


<script>
  function updateDateTime() {
    const now = new Date();
    document.getElementById('time').textContent = now.toLocaleTimeString();
    document.getElementById('date').textContent = now.toLocaleDateString();
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();
</script>
