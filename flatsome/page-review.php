<?php
/*
Template name: Page - Review
*/


get_header();
do_action( 'flatsome_before_page' ); ?>
<style>
    @font-face {
        font-family: stamped-font;
        src: url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.eot?rkevfi);
        src: url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.eot?rkevfi#iefix) format('embedded-opentype'), url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.ttf?rkevfi) format('truetype'), url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.woff?rkevfi) format('woff'), url(https://cdn-stamped-io.azureedge.net/fonts/stamped-font.svg?rkevfi#stamped-font) format('svg');
        font-weight: 400;
        font-style: normal
    }
    
    .stamped-summary-ratings {
        width: 300px!important;
        margin-bottom: 20px!important;
        color: #999;
        font-size: 12px;
        line-height: normal;
        margin-right: 20px;
        margin-bottom: 15px
    }
    
    .summary-rating {
        margin-bottom: 2px
    }
    
    .summary-rating-title {
        font-size: 0!important;
        width: 95px!important;
        display: inline-block;
        cursor: pointer
    }
    
    .summary-rating-bar {
        height: 15px!important;
        vertical-align: middle;
        width: 48%!important;
        display: inline-block;
        background: #f0f0f0;
        border: none;
        text-align: center;
        cursor: pointer
    }
    
    .summary-rating-bar>div {
        font-size: 0!important;
        height: 15px;
        line-height: 0;
        padding: 0
    }
    
    .summary-rating-bar-content {
        background: #ffd200;
        line-height: normal;
        display: flex;
        padding: 1px 0 2px;
        word-wrap: initial;
        word-break: initial
    }
    
    .summary-rating-count {
        color: #333!important;
        width: 15%;
        display: inline-block;
        text-align: left;
        padding-left: 10px;
        color: #ccc;
        font-size: 14px;
        position: absolute
    }
    
    .summary-rating:nth-child(1) .summary-rating-title:before,
    .summary-rating:nth-child(2) .summary-rating-title:before,
    .summary-rating:nth-child(3) .summary-rating-title:before,
    .summary-rating:nth-child(4) .summary-rating-title:before,
    .summary-rating:nth-child(5) .summary-rating-title:before {
        font-family: stamped-font!important;
        font-size: 17px;
        width: 200px!important;
        letter-spacing: -1px;
        color: #999
    }
    
    .summary-rating:nth-child(1) .summary-rating-title:before {
        content: '\f005\f005\f005\f005\f005'
    }
    
    .summary-rating:nth-child(2) .summary-rating-title:before {
        content: '\f005\f005\f005\f005\f006'
    }
    
    .summary-rating:nth-child(3) .summary-rating-title:before {
        content: '\f005\f005\f005\f006\f006'
    }
    
    .summary-rating:nth-child(4) .summary-rating-title:before {
        content: '\f005\f005\f006\f006\f006'
    }
    
    .summary-rating:nth-child(5) .summary-rating-title:before {
        content: '\f005\f006\f006\f006\f006'
    }
    
    .summary-rating-count:before {
        content: '('
    }
    
    .summary-rating-count:after {
        content: ')'
    }
    
    .summary-rating-title {
        font-size: 0!important;
        width: 95px!important
    }
    
    .stamped-review {
        border-top: 1px solid #eee;
        margin-bottom: 30px;
        padding-top: 25px
    }
    
    .stamped-review-header {
        font-size: 14px;
        width: 100%;
        line-height: 18px
    }
    
    .stamped-review-avatar {
        float: left;
        position: relative;
        float: left;
        padding: 0;
        margin-right: 10px;
        color: #bbb
    }
    
    .stamped-review[data-verified=buyer] .stamped-review-avatar:before {
        content: '\e904';
        font-family: stamped-font;
        font-size: 21px!important;
        position: absolute;
        right: -5px;
        bottom: 0;
        color: #1cc286
    }
    
    .stamped-review-avatar-content {
        display: table-cell;
        vertical-align: middle;
        height: 56px;
        width: 55px;
        font-weight: 700;
        font-size: 18px;
        text-align: center;
        text-transform: inherit;
        font-style: initial;
        margin-right: 10px
    }
    
    .stamped-review-header .created,
    .stamped-review-header-byline .created {
        float: right!important;
        color: #999;
        font-size: 12px;
        font-weight: 400
    }
    
    .stamped-review .author {
        margin-right: 7px
    }
    
    .verified-badge {
        display: block;
        font-size: 12px;
        white-space: nowrap
    }
    
    .verified-badge .icon {
        display: none;
        background: 0 0;
        float: none;
        width: auto;
        height: auto;
        margin-right: -2px
    }
    
    .stamped-review-header .verified-badge[data-type=buyer]:after {
        content: ' Verified Buyer'
    }
    
    .stamped-review-header .review-location {
        color: #999;
        font-size: 12px;
        font-weight: 400
    }
    
    .stamped-review-header-starratings {
        font-size: 20px;
        display: inline-block;
        margin-left: -2px
    }
    
    .fa-star:before,
    .stamped-fa-star:before {
        content: '\f005';
        color: #ffd200;
        font-family: stamped-font!important;
        font-size: 18px;
        margin-right: -1px;
        font-style: normal
    }
    
    .fa-star-o:before,
    .stamped-fa-star-o:before {
        content: '\f006';
        color: #ffd200;
        font-family: stamped-font!important;
        font-size: 18px;
        margin-right: -1px;
        font-style: normal
    }
    
    .review_content_wrapper {
        padding: 5%;
        padding-top: 3px;
        display: none
    }
    
    .review_content_wrapper.active {
        display: block
    }
    
    .review_arrow {
        float: right;
        padding: 10px 0;
        font-size: 180%;
        font-weight: 700
    }
    
    .product-detail {
        border-top: 1px solid #eee;
        margin-bottom: 30px;
        padding-top: 25px
    }
</style>

<style>
    .fa-star,
    .fa-star-checked,
    .fa-star-half-o,
    .fa-star-o,
    .stamped-fa-star,
    .stamped-fa-star-checked,
    .stamped-fa-star-half-o,
    .stamped-fa-star-o {
        color: #ffd200;
        padding: 0;
        font-family: stamped-font !important;
        font-size: 18px;
        text-transform: none !important;
        font-style: normal !important;
        margin-right: -1px;
    }
    
    .stamped-fa-star-half-o:before {
        content: '\f123';
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] a {
        text-decoration: none;
        border: none;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-widget-title {
        margin-bottom: 20px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-widget-text {
        margin-left: 10px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-author {
        color: grey;
        font-weight: normal;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"]:not([data-label-subtitle]) .stamped-widget-text:before {
        content: "4.9/5 Based on "
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"]:not([data-label-subtitle]) .stamped-widget-text:after {
        content: " Reviews"
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-verified-label {
        color: #1cc286;
        font-weight: normal;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-verified-label[data-verified-type="2"]:after {
        content: ' \e904  Verified Buyer';
        font-family: 'stamped-font', 'Open Sans';
        word-spacing: -5px;
        font-weight: normal;
    }
    
    .stamped-fa-star,
    .stamped-fa-star-o,
    .stamped-fa-star-half-o {
        color: gold;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-title {
        font-weight: bold;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-title a:visited {
        color: #4e387e;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] a.stamped-review-product {
        font-size: 12px;
        font-weight: normal;
        color: #777;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-ratings-wrapper:nth-child(odd) {
        clear: both;
        display: inline-block;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-ratings-wrapper:nth-child(even) {
        margin-right: 0px !important;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-ratings-wrapper {
        width: 100% !important;
        margin-right: 4% !important;
        text-align: center !important;
        vertical-align: top !important;
        width: 48% !important;
        text-align: left !important;
        padding-top: 30px !important;
        margin-bottom: 35px !important;
        padding-bottom: 15px !important;
        float: left;
        border-top: 1px solid #f0f0f0;
        padding-top: 10px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-message {
        font-weight: normal;
        margin: 10px 0px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-message:before {
        content: '" ';
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-message:after {
        content: ' \201D';
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-message:before,
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-message:after {
        font-family: cursive;
        font-size: 20px;
        line-height: 10px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-image {
        height: 145px;
        width: 100px;
        float: left;
        margin-right: 20px;
        display: inline-block;
        vertical-align: top;
        text-align: center;
        position: relative;
        padding-left: 0 !important;
        z-index: 100;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-message-image-block img {
        height: 80px;
        margin: 10px 0px;
        border-radius: 3px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] img {
        margin-left: 0 !important;
        margin-right: 10px !important;
        box-shadow: 0px 0px 4px #CCB;
        padding: 3px;
        border-radius: 5px;
        text-align: center;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-products-reviews-title {
        font-style: italic;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-date {
        float: right;
        font-size: 12px;
        color: #999;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-pagination {
        font-size: 15px;
        text-align: center;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] span.stamped-pagination-page {
        padding: 3px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-pagination a {
        cursor: pointer;
        padding: 0px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] #stamped-pagination-next {
        float: none;
        position: inherit;
        margin-left: 5px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] #stamped-pagination-next a:before {
        content: '>';
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] #stamped-pagination-prev {
        float: none;
        position: inherit;
        margin-right: 5px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] #stamped-pagination-prev a:before {
        content: '<';
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-ratings-wrapper > div {
        position: relative;
        padding-left: 120px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-date {
        padding-left: 0 !important;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-products-reviews-reply {
        background: none;
        padding: 15px;
        margin-top: 15px;
        border-top: 3px solid #eee;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-options ul {
        margin: 0px;
        padding: 0px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"] .stamped-reviews-options ul li {
        list-style: disc;
        margin: 5px 30px;
        padding: 0px;
        font-size: 12px;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"][data-product-image="false"] .stamped-ratings-wrapper > div {
        padding: 0px !important;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"][data-product-image="false"] .stamped-reviews-image {
        display: none;
    }
    
    #stamped-reviews-widget[data-widget-type="full-page"][data-show-avatar="False"] .stamped-ratings-wrapper > div {
        padding-left: 0px !important;
    }
    
    @media only screen and (max-width: 650px),
    only screen and (max-device-width: 650px) {
        #stamped-reviews-widget[data-widget-type="full-page"] .stamped-ratings-wrapper > div {
            text-align: left;
        }
        #stamped-reviews-widget[data-widget-type="full-page"] .stamped-ratings-wrapper {
            width: 100% !important;
            margin-right: 0 !important;
            margin-bottom: 20px !important;
            text-align: center !important;
        }
    }
    
    .stamped-widget-buttons {
        margin-bottom: 20px;
        display: none;
    }
    
    .btn-product-reviews,
    .btn-site-reviews {
        cursor: pointer;
    }
    
    .btn-product-reviews:before {
        content: 'Product Reviews';
    }
    
    .btn-site-reviews:before {
        content: 'Site Reviews';
    }
    
    .stamped-full-page-tabs ul {
        margin: 0px;
        padding: 0px;
        text-align: center;
        margin-top: 20px;
    }
    
    .stamped-full-page-tabs ul li.active {
        font-weight: bold;
        background: #fafafa;
        box-shadow: 0px 1px 2px #ccc;
    }
    
    .stamped-full-page-tabs ul li {
        display: inline-block;
        margin-right: 15px;
        font-size: 15px;
        border: 1px solid #777;
        padding: 10px 20px;
    }
    
    .stamped-full-page-tabs ul li a {
        color: black;
    }
    
</style>
<div id="content" class="content-area page-wrapper" role="main">
	<div class="row row-main">
		<div class="large-12 col">
			<div class="col-inner">
				<?php if(get_theme_mod('default_title', 0)){ ?>
				<header class="entry-header">
					<h1 class="entry-title mb uppercase"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
				<?php } ?>
        <?php
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
          // WP_Query arguments
          $args = array (
              'post_type'              => array( 'review' ),
              'post_status'            => array( 'publish' ),
              'order'                  => 'DESC',
              'posts_per_page'         => 20,
              'paged'                  => $paged
          );

          // The Query
          $reviews = new WP_Query( $args );
        ?>
				<div id="stamped-reviews-widget" data-widget-type="full-page" data-random="True" data-min-rating="1" data-show-avatar="True" data-lang="en">
            <div class="stamped-widget-title">
              <span class="stamped-widget-text">368</span>
            </div>
            <div class="stamped-summary-ratings" data-count="186" style="margin-top: -10px;">
                <div class="summary-rating">
                    <div class="summary-rating-title">5 Star</div>
                    <div class="summary-rating-bar" data-rating="5">
                        <div class="summary-rating-bar-content" style="width: 90%;" data-rating="90">95%&nbsp;</div>
                    </div>
                    <div class="summary-rating-count">348</div>
                </div>
                <div class="summary-rating">
                    <div class="summary-rating-title">4 Star</div>
                    <div class="summary-rating-bar" data-rating="4">
                        <div class="summary-rating-bar-content" style="width: 6%;" data-rating="6">3%&nbsp;</div>
                    </div>
                    <div class="summary-rating-count">13</div>
                </div>
                <div class="summary-rating">
                    <div class="summary-rating-title">3 Star</div>
                    <div class="summary-rating-bar" data-rating="3">
                        <div class="summary-rating-bar-content" style="width: 2%;" data-rating="2">3%&nbsp;</div>
                    </div>
                    <div class="summary-rating-count">4</div>
                </div>
                <div class="summary-rating">
                    <div class="summary-rating-title">2 Star</div>
                    <div class="summary-rating-bar" data-rating="2">
                        <div class="summary-rating-bar-content" style="width: 1%;" data-rating="1">1%&nbsp;</div>
                    </div>
                    <div class="summary-rating-count">2</div>
                </div>
                <div class="summary-rating">
                    <div class="summary-rating-title">1 Star</div>
                    <div class="summary-rating-bar" data-rating="1">
                        <div class="summary-rating-bar-content" style="width: 1%;" data-rating="1">0%&nbsp;</div>
                    </div>
                    <div class="summary-rating-count">1</div>
                </div>
            </div>
            <div class="stamped-reviews-wrapper">
            <?php 
              // The Loop
              if ( $reviews->have_posts() ) {
                  $count = 1;
                  while ( $reviews->have_posts() ) {
                      $reviews->the_post();
                      $count++;
            ?>
                <?php 
                    if (class_exists('MultiPostThumbnails')) { 
                        if (MultiPostThumbnails::has_post_thumbnail('review', 'buyer-avatar-image')) {
                            // use the MultiPostThumbnails to get the image ID
                            $image_id = MultiPostThumbnails::get_post_thumbnail_id( 'review', 'buyer-avatar-image', get_the_ID() );
                            // define full size src based on image ID
                            $buyer_avatar = wp_get_attachment_image_src( $image_id, 'thumbnail' ); 
                        }
                    }
                    $review_text = esc_html(get_post_meta(get_the_ID(), 'review_text', true));
                    $review_title = esc_html(get_post_meta(get_the_ID(), 'review_title', true));
                    $buyer_country = esc_html(get_post_meta(get_the_ID(), 'buyer_country', true));
                    $product_link = esc_html(get_post_meta(get_the_ID(), 'product_link', true));
                    $product_images_full = get_the_post_thumbnail_url(get_the_ID(),'full'); 
                    $product_images = get_the_post_thumbnail_url(get_the_ID(),'medium'); 
                ?>
                <div class="stamped-ratings-wrapper stamped-review-card">
                    <div class="stamped-reviews-image">
                      <a class="image-lightbox" rel="group noopener noreferrer" href="<?php echo $product_images_full; ?>"><img src="<?php echo $product_images; ?>" style="max-height: 100%; max-width: 100%; width: auto; height: auto; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"></a>
                    </div>
                    <div class="stamped-reviews-date" data-date="<?php echo (ceil($count/3)); ?>">12/05/2018</div>
                    <div class="stamped-reviews-rating stamped-style-color-star"><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i><i class="stamped-fa stamped-fa-star"></i></div>
                    <?php if ($review_title != '') { ?>
                    <div class="stamped-reviews-title"><a href="<?php echo ($product_link != '') ? $product_link : '/' ?>" class="stamped-review-title stamped-style-color-link"><span><?php echo $review_title; ?></span></a></div>
                    <?php } ?>
                    <?php if ($review_text != '') { ?>
                    <div class="stamped-reviews-message stamped-style-color-text"><?php echo $review_text; ?></div>
                    <?php } ?>
                    <div class="stamped-reviews-author stamped-style-color-text"><?php the_title(); ?><span class="stamped-verified-label stamped-style-color-verified" data-verified-type="2"></span></div>
                    <?php if ($buyer_country != '') { ?>
                    <div class="stamped-reviews-location"><?php echo $buyer_country; ?></div>
                    <?php } ?>
                    <div class="stamped-products-reviews-title"><a href="<?php echo ($product_link != '') ? $product_link : '/' ?>" class="stamped-review-product style-color-link">Quilt Blanket</a></div>
                </div>
            <?php   } } ?>
            <div style="clear: both;"></div>
            <div class="paginate page-numbers nav-pagination links text-center">
            <?php 
              $total_pages = $reviews->max_num_pages;

              if ($total_pages > 1){
          
                  $current_page = max(1, get_query_var('paged'));
          
                  echo paginate_links(array(
                      'base' => get_pagenum_link(1) . '%_%',
                      'format' => 'page/%#%',
                      'current' => $current_page,
                      'total' => $total_pages,
                      'prev_text'    => __('« prev'),
                      'next_text'    => __('next »'),
                  ));
              }  
            ?>
            </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <script>
            jQuery('[data-date]').each(function() {
                var day = parseInt(jQuery(this).attr('data-date'));
                var currentdate = new Date();
                var showDate = new Date(currentdate.setDate(currentdate.getDate() - day));
                var text = (showDate.getMonth() + 1) + "/" + showDate.getDate() + "/" + showDate.getFullYear();
                jQuery(this).html(text);
            });
        </script>


			</div><!-- .col-inner -->
		</div><!-- .large-12 -->
	</div><!-- .row -->
</div>

<?php
do_action( 'flatsome_after_page' );
get_footer();


?>



