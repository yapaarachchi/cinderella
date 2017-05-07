<?php
?>

	<nav class="navbar fixed-top navbar-inverse bg-inverse navbar-toggleable-md" >
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="../../">
		<img src="../../assets/icons/home.svg" width="30" height="30" alt="">
		<b>Cinderella</b>
		</a>
		
		<!-- Large Screens -->
		<ul class="nav navbar-nav hidden-md-down">
		<li class="nav-item">
		  <a class="nav-link" href="../layout/AboutUs.php">About Us</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="../layout/ContactUs.php">Contact Us</a>
		  </li>
		</ul>
		
		<?php
			if($isLoggedIn === false){				
		?>
			<ul class="nav navbar-nav hidden-md-down">
			  <li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModalGeneral"><u>Sign In</u></a>
			  </li>
			</ul>
		<?php
			}
			else{
		?>
			<ul class="nav navbar-nav">
			
			<?php
			if($auth->getUserRole($auth->getEmail()) == '3')
			{
			?>
			  <li class="nav-item">
				<a class="nav-link active" href="../Merchant/"><u>Merchant Page</u></a>
			  </li>
			  
			  <?php
			}
			  ?>
			  <li class="nav-item">
				<a class="nav-link" href="#" id="signOut"><u>Sign Out</u></a>
			  </li>
			</ul>
		<?php
			}
		?>
		<!-- Toggle - Small Screen -->
		<div class="collapse navbar-toggleable-md" id="navbarNavDropdown">
			<ul class="nav navbar-nav hidden-lg-up">
			<?php
			if($isLoggedIn === false){				
		?>
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModalGeneral"><u>Sign In</u></a>
			  </li>
		<?php
			}
		?>
			</ul>
		</div>
		<span class = " hidden-md-down" style="color:white; margin-left: 30px">Advertise With us: Call - <?php echo Config::$tp; ?></span>
		<div class="navbar-toggler-right hidden-md-down"> <a class="btn btn-primary-unicorn btn-md btn-block" href="../Search" role="button">Search</a>  </div>
	</nav>

	<div class="modal fade" id="LogInModalGeneral" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div id="loginModalGeneralError" style="padding-bottom: 10px;">
				</div>
				<form id="loginGeneral"  accept-charset="utf-8">
				
				<div class="form-group">
					<label class="form-control-label" >Username</label>
					<input class="form-control" id="loginUsername" name="loginUsername"  placeholder="youremail@example.com" type="email" aria-describedby="emailHelp" />
					<div id="loginUsername_validate" class="form-control-feedback"></div>
				</div>
				
				<div class="form-group">
					<label class="form-control-label" >Password</label>
					<input class="form-control" type="password"  id="loginPassword" name="loginPassword" placeholder="Password"/>
					<div id="loginPassword_validate" class="form-control-feedback"></div>
				</div>
				
				<input type="hidden" name="action" value="login"/>
				
				<div class="form-check">
					<label class="form-check-label">
					<input id="loginRememberme" name="loginRememberme" class="form-check-input" type="checkbox" value="1">
					Remember me
					</label>
				</div>
				
			  </div>
			  <div class="modal-footer">
				<a href="../layout/ForgotPassword.php">Forgot Password ?</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-primary">Sign In</button>
				</form>
			  </div>
			</div>
		</div>
	</div>
