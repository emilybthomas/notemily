<?php
/**
 * Template part for displaying header page title
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package trydo
 */
// Get Value
$trydo_options = Helper::trydo_get_options();
$banner_layout = Helper::trydo_banner_layout();
$banner_area = $banner_layout['banner_area'];
$banner_style = $banner_layout['banner_style'];

if ( is_home() ) {
    get_template_part('/template-parts/title/blog-title');
} elseif( is_search() ) {
    get_template_part('/template-parts/title/blog-title');
} elseif( !is_front_page() && is_page() ) {
    if ("no" !== $banner_area && "0" !== $banner_area) {
        get_template_part('/template-parts/title/layout', $banner_style);
    }
} elseif(is_archive()) {
    get_template_part('/template-parts/title/blog-title');
} elseif(is_singular('portfolio')) {
    get_template_part('/template-parts/title/single-portfolio-title');
} elseif(is_single()) {
    // get_template_part('/template-parts/title/single-post-title');
} else {
    // Nothing
}