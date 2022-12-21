<?php
	include('includes/common.php');

  if (SHOW_PASSWORD) {
    echo password_hash('testpp123', PASSWORD_DEFAULT);
    exit();
  }

	if (getPost('command') === 'login') {
		$username = getPost('username');
		$password = getPost('password');

    if (!validateVar($username) || !validateVar($password)) {
      if (!validateVar($username)) {
        $username_msg = 'Email is required.';
      } else if (!validateVar($username, FILTER_VALIDATE_EMAIL)) {
        $username_msg = 'Enter valid email address.';
      }

      if (!validateVar($password)) {
        $password_msg = 'Password is required.';
 }
    } else {
      $row = $obj_admin->getUserByUsername($username);
      if ($row) {
        if ($obj_auth->authenticate($row, $password)) {
          redirect_header(ADMIN_URL . 'index.php');
        }
      }
    }
	}

	include('common/header-auth.php');
?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post">
		    <input type="hidden" name="command" value="login" />

        <div class="mb-3">
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Email" name="username" value="<?php echo getPost('username') ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <?php echo isset($username_msg) ? printErrorMsg($username_msg) : ''; ?>
        </div>

        <div class="mb-3">
          <div class="input-group">
            <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo getPost('password') ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <?php echo isset($password_msg) ? printErrorMsg($password_msg) : ''; ?>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="rememberme" value="yes" />
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
<?php
	include('common/footer-auth.php');