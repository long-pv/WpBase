<?php
$flexible_content = get_field('flexible_content') ?? '';

if ($flexible_content):
	foreach ($flexible_content as $flexible):
		// custom class
		$customClass = 'secSpace ';
		$sectionId = custom_name_block($flexible['acf_fc_layout']);
		$customClass .= $sectionId;
		$customClass .= '  ';
		$customClass .= $flexible['block_info']['custom_class'] ?? '';
		?>
		<section class="<?php echo $customClass; ?>" id="<?php echo $sectionId; ?>">
			<?php
			$args['flexible'] = $flexible;
			get_template_part('template-parts/block/' . $flexible['acf_fc_layout'], '', $args);
			?>
		</section>
		<?php
	endforeach;
endif;
?>