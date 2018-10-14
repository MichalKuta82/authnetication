<?php include 'includes/header.php'; 

if (!isset($_SESSION['user'])) {
	header("Location: register.php");
}
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <h5 class="card-header text-center">Dashboard</h5>
        <div class="card-body">
        	<h2>Hello <?php echo $_SESSION['user']->name; ?></h2>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
