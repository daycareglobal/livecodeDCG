<?php foreach ($articles as $key => $value) { ?>
	<p class="list">
		<?php if($value->type == "Blog") { ?>
			<a target="_blank" data-title="<?php echo $value->title; ?>" href="<?php echo site_url('blogs/'.$value->slug) ?>"><?php echo $value->title; ?> - blog</a>
		<?php } else if($value->type == "News") { ?>
			<a target="_blank" data-title="<?php echo $value->title; ?>" href="<?php echo site_url('news/'.$value->slug) ?>"><?php echo $value->title; ?> - news</a>
		<?php } ?>
	</p>
<?php } ?>
<?php if(!$articles) { ?>
	<div class="no-record">Sorry! No Similar Articles Found</div>
<?php } ?>