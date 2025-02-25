<?php
/**
 * HTML for the Manage Snippets page.
 *
 * @package    Code_Snippets
 * @subpackage Views
 *
 * @var Manage_Menu $this
 */

namespace Code_Snippets;

/* Bail if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$types = array_merge( [ 'all' => __( 'All Snippets', 'code-snippets' ) ], code_snippets()->get_types() );

$current_type = isset( $_GET['type'] ) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : 'all';
$current_type = isset( $types[ $current_type ] ) ? $current_type : 'all';

?>

<div class="wrap">
	<h1><?php
		esc_html_e( 'Snippets', 'code-snippets' );

		$this->page_title_actions( code_snippets()->is_compact_menu() ? [ 'add', 'import', 'settings' ] : [ 'add', 'import' ] );

		$this->list_table->search_notice();
		?></h1>

	<?php $this->print_messages(); ?>

	<h2 class="nav-tab-wrapper" id="snippet-type-tabs">
		<?php

		foreach ( $types as $type_name => $label ) {

			if ( $type_name === $current_type ) {
				printf( '<a class="nav-tab nav-tab-active" data-type="%s">', esc_attr( $type_name ) );

			} else {
				printf( '<a class="nav-tab" href="%s" data-type="%s">',
					esc_url( add_query_arg( 'type', $type_name ) ), esc_attr( $type_name )
				);
			}

			echo esc_html( $label ), 'all' === $type_name ? '' : ' <span>' . esc_html( $type_name ) . '</span>', '</a>';
		}

		?>
		<a class="button button-large nav-tab-button go-pro-button" href="https://codesnippets.pro" target="_blank"><?php
			echo wp_kses( __( 'Go <span>Pro</span>', 'code-snippets' ), [ 'span' => [] ] );
			?></a>
	</h2>

	<?php
	if ( $desc = code_snippets()->get_type_description( $current_type ) ) {
		echo '<p class="snippet-type-description">', esc_html( $desc );

		$type_names = [
			'php'  => __( 'function snippets', 'code-snippets' ),
			'html' => __( 'content snippets', 'code-snippets' ),
			'css'  => __( 'style snippets', 'code-snippets' ),
			'js'   => __( 'javascript snippets', 'code-snippets' ),
		];

		/* translators: %s: snippet type name */
		$learn_more_text = sprintf( __( 'Learn more about %s &rarr;', 'code-snippets' ), $type_names[ $current_type ] );

		printf( ' <a href="%s" target="_blank">%s</a></p>',
			esc_url( "https://codesnippets.pro/learn-$current_type/" ), esc_html( $learn_more_text ) );
	}
	?>

	<?php
	do_action( 'code_snippets/admin/manage/before_list_table' );
	$this->list_table->views();
	?>

	<form method="get" action="">
		<?php
		$this->list_table->required_form_fields( 'search_box' );
		$this->list_table->search_box( __( 'Search Snippets', 'code-snippets' ), 'search_id' );
		?>
	</form>

	<form method="post" action="">
		<input type="hidden" id="code_snippets_ajax_nonce" value="<?php echo esc_attr( wp_create_nonce( 'code_snippets_manage_ajax' ) ); ?>">

		<?php

		/** @var Manage_Menu $this */
		$this->list_table->required_form_fields();
		$this->list_table->display();
		?>
	</form>

	<?php do_action( 'code_snippets/admin/manage' ); ?>
</div>
