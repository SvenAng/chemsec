<?php
global $business_groups;

$text = $business_groups[0]['text'];
?>
<p><?php echo $text; ?></p>

<div data-slider-id="business-groups" class="slider">
<?php
foreach ($business_groups[0]['companies'] as $key => $business_group):

    $image = get_acf($business_group['image'], array(
        'size' => 'business-group'
    ));

	if ( ! empty( $business_group['link'] ) ) :

		$html = '<a href="' . $business_group['link'] . '" target="' . $business_group['link-target'] . '">' . $image . '</a>';
	else:

		$html = $image;

	endif;

    ?>

    <div>
        <?php echo $html; ?>
    </div>

<?php endforeach; ?>
</div>