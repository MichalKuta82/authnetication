<?php include 'includes/header.php'; 

if (isset($_SESSION['user'])) {
  header("Location: index.php");
}

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$user->register($name, $email, $password);
}
?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="card">
            <h5 class="card-header text-center">Register form</h5>
            <div class="card-body">
            	<?php
            		if (isset($_SESSION['error'])) {
            			echo '<div class="alert alert-danger role="alert">' . $_SESSION['error'] . '</div>';
            		}
            		?>
              <form role="form" method="post" action="">
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                  <label for="email">Email address:</label>
                  <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" class="form-control" id="pwd" name="password">
                </div>
                <button type="submit" class="btn btn-primary float-right" name="submit">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container -->

  <?php include 'includes/footer.php'; ?>
