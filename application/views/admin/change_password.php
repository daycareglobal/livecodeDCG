<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
	<script src="<?php echo base_url('assets/bootstrap/jquery-1.11.2.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</head>
<body>
<div class="container-fluid">
<br />
<?php
	if (isset($last_status['message'])) {
		foreach ($last_status['message'] as $message) {
			if (strlen($message) > 4) {
				echo '<div class="col-md-4 pull-right alert alert-dismissible ' . $last_status['class'] . '" style="margin:10px">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . 
				$message . '
				</div>';
			}
		}
	}
?>
</div>
<div class="container">
	<form method="post" action="<?php echo base_url('admin/Registration/changePassword') ?>"> 
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<strong>Change Password</strong>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group <?php echo (strlen(form_error('current_password')) > 0 ? 'has-error' : '') ?>">
							<label class="control-label">Current Password</label>
							<input type="password" class="form-control" name="current_password" value=""/>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group <?php echo (strlen(form_error('new_password')) > 0 ? 'has-error' : '') ?>">
							<label class="control-label">New Password</label>
							<input type="password" class="form-control" name="new_password" value="">
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group <?php echo (strlen(form_error('confirm_new_password')) > 0 ? 'has-error' : '') ?>">
							<label class="control-label">Confirm New Password</label>
							<input type="password" class="form-control" name="confirm_new_password" value="">
						</div>
					</div>
				</div>
			</div>
				
			<div class="panel-footer">
				<div class="row">
					<div class="form-group">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<input type="submit" value="Save" name="submit" class="btn btn-success">
							<a href="<?php echo site_url('admin/admin') ?>" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
</body>
</html>