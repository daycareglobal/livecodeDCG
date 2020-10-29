<option></option>

<?php foreach ($city_list as $key => $value) { ?>
	<option <?php echo ($value->id == $city_id) ? 'selected' : ''; ?> value="<?php echo $value->id; ?>"><?php echo $value->name ?></option>
<?php } ?>
