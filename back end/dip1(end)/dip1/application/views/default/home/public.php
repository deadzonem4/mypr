<div class="row">
	<?php $item_count = 0; ?>
	<?php foreach($data['news'] as $news): ?>
		<?php if($item_count == 0): $class = 'col-md-12'; $length = 300; else: $class = 'col-md-4'; $length = 200; endif; ?>
		<?php $item_count++; ?>
		<div class="<?php echo $class; ?> news-item news-item-<?php echo $item_count; ?>">
			<?php if($item_count == 1): ?><h3><a href="<?php echo base_url('news/detail/' . $news->idpost); ?>"><?php echo $news->title; ?></a></h3><?php else: ?><h4><a href="<?php echo base_url('news/detail/' . $news->idpost); ?>"><?php echo $news->title; ?></a></h4><?php endif; ?>
			<img src="<?php echo assets_url('uploads/' . $news->image); ?>" alt="<?php echo $news->title; ?>" class="img-responsive" />
			<p class="alert alert-warning author-info">
				
				<i class="fa fa-fw fa-calendar-o"></i> <?php echo date('d M, Y h:i a', strtotime($news->add_date)); ?>
			</p>
			<div class="news-excerpt">
				<?php echo substr(strip_tags($news->body), 0, $length); ?> ... <a href="<?php echo base_url('news/detail/' . $news->idpost); ?>">read more <i class="fa fa-fw fa-external-link"></i></a>
			</div>
		</div>
		<?php if($item_count % 3 == 1): ?> <div class="clearfix"></div><?php endif; ?>
		<?php if($item_count >= 10): break; endif; ?>
	<?php endforeach; ?>
</div>