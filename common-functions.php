<?php
/**
 * Child-Theme functions and definitions
 */

include_once 'inc/CustomPostTypes.class.php';
include_once 'inc/Shortcodes.class.php';
include_once 'inc/EnqueStyleScript.php';
include_once 'inc/SubmitQuestion.php';

new Sidebars();
new CustomPostTypes();
new Shortcodes();

/**
 * @param $length
 * @return int
 */
function custom_excerpt_length( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * @param $more
 * @return string
 */
function new_excerpt_more( $more ) {
    return '.....';
}
add_filter('excerpt_more', 'new_excerpt_more');

function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
    if(empty($first_img))
        $first_img = get_stylesheet_directory_uri().'/img/default.jpg';
    return $first_img;
}


function get_slug() {
    $post_type = get_post_type();
    $post_type_slug = '';
    if ($post_type) {
        $post_type_data = get_post_type_object($post_type);
        $post_type_slug = $post_type_data->rewrite['slug'];
    }
    return $post_type_slug;
}

add_filter( 'template_include', 'cyb_post_template');
function cyb_post_template( $template ) {
    if ( is_single( 'submit-question' )  ) {
        $new_template = locate_template( array( 'submit-question.php' ) );
        if ( '' != $new_template ) {
            return $new_template ;
        }
    }
    return $template;
}

/** get countries list */
function the_countries($args) {
    global $wp_country;
    $wp_country->dropdown('', true, $args);
}

function get_countries() {
    global $wp_country;
    return $wp_country->countries_list();
}

function get_posts_by_type() {
    global $posts;

    $type = get_slug();
    $taxO = get_object_taxonomies($type);
    $taxonomy = $taxO[0];
    $terms = array();
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ));
    $post_terms = array();
    foreach($terms as $t) {
        $post_terms[] = array(
            'id' => $t->term_id,
            'slug' =>$t->slug,
            'name' =>$t->name,
        );
    }
    return array(
        'type' => $type,
        'taxonomy' => $taxonomy,
        'post_terms' => $post_terms
    );
}

add_action('wp_ajax_submit_question', 'submit_question');
add_action('wp_ajax_nopriv_submit_question', 'submit_question');
function submit_question() {
    $s = new SubmitQuestion($_POST);
    $s->validate_fields();
    $s->insert_form_data();
}
