<?php

/**
 * 
 */
class User extends mysqli
{
	
	function __construct()
	{
		Parent::__construct('', '', '', '');

		if ($this->connect_error) {
    		$_SESSION['error'] = 'DB Connection error: ' . $this->connect_error;
    		return true;
		}
	}

	public function register($name, $email, $password)
	{

		$hash = password_hash($password, PASSWORD_DEFAULT);
		$token = bin2hex(random_bytes(4));

		$sql = "SELECT * FROM users WHERE email='$email'";
		$run = $this->query($sql);
		if ($run->num_rows > 0) {
			$_SESSION['error'] = "Email Already Exists";
			return true;
		}else{
			$sql = "INSERT INTO users(name, email, password, token, active) VALUES('$name', '$email', '$hash', '$token', 0)";
			$run = $this->query($sql);
			if ($run) {
				$user = $this->getuser($email);
				$_SESSION['id'] = $user->id;
				//$this->send_mail($user->email, $user->id, $token);
				header("Location: activate.php");
			}else{
				$_SESSION['error'] = "Something went wrong";
			}
		}
	}

	public function getuser($email)
	{
		$sql = "SELECT * FROM users WHERE email='$email'";
		$run = $this->query($sql);
		$row = $run->fetch_object();
		return $row;
	}

	public function send_mail($email, $id, $token)
	{
		$subject = "Account Activation Code";

		$headers = "From: test app \r\n";
		$headers = "Reply-To: webmedia.dublin@gmail.com \r\n";
		$headers = "CC: michal@webmedia.ie \r\n";
		$headers = "MIME-Version : 1.0 \r\n";
		$headers = "Content-Type: text/html; hcarset=ISO-8859-1 \r\n";
		$message = '<html><body>';
		$message = '<h6>Your Activation Code</h6>';
		$message = '<h3>' . $token . '</h3>';
		$message = '<h1>OR</h1>';
		$message = '<h3>' . $_SERVER['SERVER_NAME'] . '/activate.php?active=' . $token . '&id=' . $id . '</h3>';
		$message = '</body></html>';

		mail($email, $subject, $message, $headers);
	}

	public function activate($id, $token)
	{
		$sql = "UPDATE users SET active=1 WHERE id='$id' AND token='$token'";
		$run = $this->query($sql);
		if ($run) {
			$user = $this->getuserbyid($id);
			$_SESSION['user'] = $user;
			header("Location: index.php");
		}else{
			$_SESSION['error'] = "Wrong activation code";
		}
	}

	public function getuserbyid($id)
	{
		$sql = "SELECT * FROM users WHERE id='$id'";
		$run = $this->query($sql);
		$row = $run->fetch_object();
		return $row;
	}

	public function auth($email, $password)
	{
		$sql = "SELECT id FROM users WHERE email='$email' AND active=1";
		$run = $this->query($sql);
		if ($run->num_rows > 0) {
			$row = $run->fetch_object();

			$sql = "SELECT * FROM users WHERE id='$row->id'";
			$run = $this->query($sql);
			$row = $run->fetch_object();

			if (password_verify($password, $row->password)) {
				$_SESSION['user'] = $row;
				header("Location: index.php");
			}else{
				$_SESSION['error'] = "Password is not valid";
			}
		}else{
			$_SESSION['error'] = "Email does not exists or user is not active";
		}
	}
}
