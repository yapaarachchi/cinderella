	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form id="login">
			<label class="form-control-label" >Username</label><br/>
			<input class="form-control" id="loginUsername" name="loginUsername"  placeholder="youremail@example.com" type="email" aria-describedby="emailHelp" /><br/>
			
			<label class="form-control-label">Password</label><br/>
			<input class="form-control" type="password"  id="loginPassword" name="loginPassword" placeholder="Password"/><br/>
			
			<input type="hidden" name="action" value="login"/>
			
			<div class="form-check">
			<label class="form-check-label">
			<input id="loginRememberme" name="loginRememberme" class="form-check-input" type="checkbox" value="1">
			Remember me
			</label>
			</div>
			
		  </div>
		  <div class="modal-footer">
			<a href="ForgotPassword.php">Forgot Password ?</a>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary">Sign In</button>
		  </div>
		</div>
	 </div>