<?php
$flexible_content = get_field('flexible_content') ?? '';

if ($flexible_content):
	foreach ($flexible_content as $flexible):
		// custom class
		$customClass = '';
		$customClass .= custom_name_block($flexible['acf_fc_layout']);
		$customClass .= '  ';
		$customClass .= $flexible['custom_class'] ?? '';
		?>
		<section class="<?php echo $customClass; ?>">
			<?php
			$args['flexible'] = $flexible;
			get_template_part('template-parts/block/' . $flexible['acf_fc_layout'], '', $args);
			?>
		</section>
		<?php
	endforeach;
endif;
?>