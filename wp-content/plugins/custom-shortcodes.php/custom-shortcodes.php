<?php

/**
 * Plugin Name: custom-shortcode
 */

add_action('init', 'orgcallback');

function orgcallback(){
	add_shortcode('subscribe', 'first_child_terms_list');
}

function first_child_terms_list() {
	// return '<a href="#">Href</a>';

	$current_term = get_queried_object();
var_dump($current_term);
echo "0";
	// Если текущая страница не страница термина - прерываем выполнение функции
	if ( ! ( is_a( $current_term, 'WP_Term' ) ) ) {		
		return;
	}
	echo "1";

	// Если это термин не древовидной таксономии - прерываем выполнение функции
	if ( ! is_taxonomy_hierarchical( $current_term->taxonomy ) ) {

		return ;
	}
	echo "2";

	// Запрашиваем дочерние элементы верхнего уровня текущего термина
	$terms = get_terms( [
		'taxonomy'   => $current_term->taxonomy,
		'parent'     => $current_term->term_id,
		'hide_empty' => false,
	] );
	echo "3";

    var_dump($terms);

	// Если возникла ошибка запроса или терминов нет - прерываем выполнение функции
	if ( is_wp_error( $terms ) || ! $terms ) {
		return;
	}

	?>

	<ul class="terms">
	<?php foreach ( $terms as $term ): ?>

		<li class="term">
			<?php
			printf(
				'<a href="%s" class="term-link">%s</a>',
				esc_url( get_term_link( $term ) ),
				esc_html( $term->name )
			)
			?>
		</li>

	<?php endforeach; ?>
	</ul>


<?php 
}


