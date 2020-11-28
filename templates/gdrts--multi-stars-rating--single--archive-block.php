<?php // GDRTS Template: Archive Block // ?>

<div class="<?php gdrts_loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper">

		<?php

		do_action( 'gdrts-template-rating-block-before' );

		gdrts_loop()->render()->stars_overall( array(
			'title' => 'Users Average Rating: ' . gdrts_loop()->method()->calc( "rating" )
		) );

		if ( gdrts_loop()->render()->has_votes() ) {
			echo '<div class="gdrts-rating-text">';
			gdrts_loop()->render()->rating();
			echo '</div>';
		}

		gdrts_single()->json();

		do_action( 'gdrts-template-rating-block-after' );
		do_action( 'gdrts-template-rating-rich-snippet' );

		?>

    </div>
</div>
