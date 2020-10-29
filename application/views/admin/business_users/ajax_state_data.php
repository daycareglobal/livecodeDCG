<option></option>
<?php foreach ($state_list as $key => $value) { ?>
	<option <?php echo ($value->id == $state_id) ? 'selected' : ''; ?> value="<?php echo $value->id; ?>"><?php echo $value->name ?></option>
<?php } ?>
