<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class gdrts_core_demo_reviews {
	public function __construct() {
		/* Register new template storage path */
		add_filter( 'gdrts_default_templates_storage_paths', array( $this, 'templates' ) );

		/* Register new template storage path for user reviews */
		add_filter( 'gdrts_ur_load_template_storage_paths', array( $this, 'templates' ) );

		/* Save extra field value on comment edit/save */
		add_action( 'gdrts_ur_edit_comment', array( $this, 'save_extra_field' ), 10, 2 );
		add_action( 'gdrts_ur_save_comment', array( $this, 'save_extra_field' ), 10, 2 );

		/* Add extra field into the user review form */
		add_action( 'gdrts_ur_default_form_before_rating', array( $this, 'form_extra_field' ) );

		/* Display extra field value inside the review item */
		add_action( 'gdrts_ur_review_item_default_after_content', array( $this, 'review_item_extra_field' ) );

		/* Display extra field filter dropdown */
		add_action( 'gdrts_ur_post_reviews_filter_before_sort', array( $this, 'filter_extra_field' ) );

		/* Prepare query for additional filter fields */
		add_filter( 'gdrts_ur_prepare_query_filter', array( $this, 'prepare_query_filter' ) );

		/* Expand query with filter for 'host-type' */
		add_filter( 'gdrts_ur_query_filter_to_meta_query_for_host-type', array(
			$this,
			'filter_meta_query'
		), 10, 2 );

		/* Modify arguments for the stars rating method to change rating text format */
		add_filter( 'gdrts_render_single_multi_stars_rating_args_rating', array(
			$this,
			'multi_stars_rating_text'
		), 10, 5 );

		/* Modify arguments for the stars review method to change rating text format */
		add_filter( 'gdrts_render_single_multi_stars_review_args_rating', array(
			$this,
			'multi_stars_review_text'
		), 10, 4 );
	}

	public function hosting_type_list() {
		return array(
			'shared'    => 'Shared',
			'vps'       => 'VPS / Cloud',
			'reseller'  => 'Reseller',
			'dedicated' => 'Dedicated'
		);
	}

	public function templates( $paths ) {
		array_unshift( $paths, GDRTS_DR_PATH . 'templates/' );

		return $paths;
	}

	public function save_extra_field( $comment_id, $comment ) {
		$valid_types  = array_keys( $this->hosting_type_list() );
		$hosting_type = isset( $_POST['host-type'] ) ? d4p_sanitize_basic( $_POST['host-type'] ) : false;

		if ( $hosting_type !== false ) {
			if ( ! in_array( $hosting_type, $valid_types ) ) {
				$hosting_type = $valid_types[0];
			}

			update_comment_meta( $comment_id, '_gdrts_review_host_type', $hosting_type );
		}
	}

	public function form_extra_field() {
		if ( gdrts_ur()->post_type == 'host' ) {

			?>

            <div class="gdrts-review-form-field gdrts-review-form-field-host-type" data-field="host-type">
                <label for="gdrts-review-form-host-type">
                    <span>Hosting Type</span></label>
				<?php gdrts_ur_dropdown( $this->hosting_type_list(), array(
					'selected' => gdrts_the_review()->get_meta( '_gdrts_review_host_type', true, 'shared' ),
					'name'     => 'host-type',
					'id'       => 'gdrts-review-form-host-type'
				) ); ?>
            </div>

			<?php

		}
	}

	public function review_item_extra_field() {
		if ( gdrts_ur()->post_type == 'host' ) {
			$_hosting_type = gdrts_the_review()->get_meta( '_gdrts_review_host_type', true, 'shared' );

			?>

            <div class="gdrts-user-review-content-host-type">
                <h4>This review is related to</h4>
				<?php

				$_types = $this->hosting_type_list();
				echo $_types[ $_hosting_type ];

				?>
            </div>

			<?php

		}
	}

	public function filter_extra_field() {
		if ( gdrts_ur_is_filter_available( 'host' ) ) {

			?>

            <div class="gdrts-user-reviews-host-type">
                <label>Hosting</label>
				<?php

				gdrts_ur_dropdown( array_merge( array( '' => 'All' ), $this->hosting_type_list() ), array(
					'selected' => gdrts_ur_ctrl()->f( 'host-type' ),
					'class'    => 'gdrts-user-reviews-filter-element',
					'id'       => 'gdrts-ur-filter-el-host-type'
				), array(
					'filter'  => 'host-type',
					'default' => ''
				) );

				?>
            </div>

			<?php
		}
	}

	public function prepare_query_filter( $filter ) {
		$_type = isset( $_GET['host-type'] ) ? d4p_sanitize_key_expanded( $_GET['host-type'] ) : '';

		if ( in_array( $_type, array_keys( $this->hosting_type_list() ) ) ) {
			$filter['host-type'] = $_type;
		}

		return $filter;
	}

	public function filter_meta_query( $meta_query, $value ) {
		$meta_query[] = array(
			'key'   => '_gdrts_review_host_type',
			'value' => $value
		);

		return $meta_query;
	}

	public function multi_stars_rating_text( $atts, $obj, $_rating, $_stars, $_votes ) {
		$atts['rating'] = sprintf( "Rating: <strong>%s</strong>,", $_rating );
		$atts['votes']  = sprintf( _n( "%s review.", "%s reviews.", $_votes ), $_votes );

		return $atts;
	}

	public function multi_stars_review_text( $atts, $obj, $_rating, $_stars ) {
		$atts['rating'] = sprintf( "Rating: <strong>%s</strong>", $_rating );

		return $atts;
	}
}

new gdrts_core_demo_reviews();
