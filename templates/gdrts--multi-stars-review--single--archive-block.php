<?php // GDRTS Template: Archive Block // ?>

<div class="<?php gdrts_loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper">

		<?php

		do_action( 'gdrts-template-rating-block-before' );

		gdrts_loop()->render()->stars_overall( array(
			'title' => 'Editor Rating: ' . gdrts_loop()->method()->calc( "rating" )
		) );

		gdrts_single()->json();

		do_action( 'gdrts-template-rating-block-after' );
		do_action( 'gdrts-template-rating-rich-snippet' );

		?>

    </div>
</div>
