<?php
include 'includes/header.php'; 
if (isset($_GET['activate']) || isset($_POST['submit'])) {
	$token = isset($_POST['submit']) ? $_POST['activate'] : $_GET['activate'];
	$id = isset($_POST['submit']) ? $_POST['id'] : $_GET['id'];

	$user->activate($id, $token);
}
?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="card">
            <h5 class="card-header text-center">Activate your account</h5>
            <div class="card-body">
            	<?php
            	if (isset($_SESSION['error'])) {
            	echo '<div class="alert alert-danger role="alert">' . $_SESSION['error'] . '</div>';
            	}
            	?>
              <form role="form" method="post" action="">
                <div class="form-group">
                  <label for="activate">Enter your activation code</label>
                  <input type="text" class="form-control" id="activate" name="activate">
                </div>
                <input type="hidden" name="id" value="<?php if (isset($_SESSION['id'])){ echo $_SESSION['id']; }?>">
                <button type="submit" class="btn btn-primary float-right" name="submit">Activate</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container -->

  <?php include 'includes/footer.php'; ?>
