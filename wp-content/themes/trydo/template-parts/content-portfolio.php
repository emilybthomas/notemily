<!-- Start Portfolio Details Area  -->
<div class="rn-portfolio-details ptb--120 bg_color--1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-details">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Portfolio Details Area  -->

<?php
global $post;
$trydo_options = Helper::trydo_get_options();
//Get array of terms
$terms = get_the_terms( $post->ID , 'portfolio-cat', 'string');
//Pluck out the IDs to get an array of IDS
$term_ids = wp_list_pluck($terms,'term_id');

//Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
//Chose 'AND' if you want to query for posts with all terms
$rel_portfolio_query = new WP_Query( array(
    'post_type' => 'portfolio',
    'tax_query' => array(
        array(
            'taxonomy' => 'portfolio-cat',
            'field' => 'id',
            'terms' => $term_ids,
            'operator'=> 'IN' //Or 'AND' or 'NOT IN'
        )),
    'posts_per_page' => 3,
    'ignore_sticky_posts' => 1,
    'post__not_in'=>array($post->ID)
) );

if($trydo_options['trydo_enable_related_portfolio'] === 'yes' ){ ?>
    <?php
    //Loop through posts and display...
    if($rel_portfolio_query->have_posts()) { ?>
        <!-- Start Related Work  -->
        <div class="portfolio-related-work pb--120 bg_color--1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <?php if(!empty($trydo_options['trydo_related_portfolio_section_title_before_text'])){ ?>
                                <span class="theme-color font--18 fontWeight600"><?php echo esc_html($trydo_options['trydo_related_portfolio_section_title_before_text']); ?></span>
                            <?php } ?>
                            <?php if(!empty($trydo_options['trydo_related_portfolio_section_title_text'])){ ?>
                                <h2><?php echo esc_html($trydo_options['trydo_related_portfolio_section_title_text']); ?></h2>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php
                echo "<div class=\"row mt--10\">";
                while ($rel_portfolio_query->have_posts() ) : $rel_portfolio_query->the_post();
                    global $post;
                    $terms = get_the_terms($post->ID, 'portfolio-cat');
                    ?>
                    <!-- Start Single Work  -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="related-work text-center mt--30">
                            <?php if(has_post_thumbnail()){ ?>
                                <div class="thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('trydo-portfolio-thumb'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="inner">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <?php if ($terms && !is_wp_error($terms)): ?>
                                    <span class="category">
                                            <?php foreach ($terms as $term) { ?>
                                                <span><?php echo esc_html($term->name); ?></span>
                                            <?php } ?>
                                            </span>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Work  -->
                <?php endwhile;
                wp_reset_postdata();
                ?></div>
             </div>
        </div>
    <?php } ?>
    <!-- End Related Work  -->
<?php }
