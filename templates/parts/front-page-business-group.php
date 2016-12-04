<?php
global $business_groups;

$business_groups = get_field('chemsec_business_group', get_option('page_on_front'));

if ( isset( $business_groups[0]['title'] ) ) {

	$title = '<h3 class="block-title">' . $business_groups[0]['title'] . '</h3>';
	$html = $title;

	if ( $business_groups[0]['title-link'] && ! empty( $business_groups[0]['title-link-url'] ) ) {

		$html = '<a href="' . $business_groups[0]['title-link-url'] . '" target="' . $business_groups[0]['title-link-target'] . '">' . $title . '</a>';

	}

	echo $html;

}

if( isset($business_groups[0]['companies']) && $business_groups[0]['companies']) {

    get_template_part( 'templates/parts/content', 'business-group' );

} else {

    get_template_part( 'templates/parts/content', 'none' );

}
?>