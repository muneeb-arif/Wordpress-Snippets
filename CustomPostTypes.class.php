<?php

final class CustomPostTypes {

    public function __construct() {

        // remove admin menu pages
        add_action( 'admin_init', array($this, 'remove_menu_pages' ));

        add_action( 'init', array($this, 'mypost_cpt'), 0 );
        add_action( 'init', array($this,'post_tax'), 0 );
    }
    /**
     * Register CPT
     */
    public function mypost_cpt() {
        $labels = array(
            'name'                  => _x( 'My Posts', 'Post Type General Name', 'sitedomain' ),
            'singular_name'         => _x( 'My Posts', 'Post Type Singular Name', 'sitedomain' ),
            'menu_name'             => __( 'My Posts', 'sitedomain' ),
            'name_admin_bar'        => __( 'My Posts', 'sitedomain' ),
            'archives'              => __( 'My Posts', 'sitedomain' ),
        );
        $this->register_post('my_posts','My Posts', $labels, 'dashicons-book-alt');
    }
    public function post_tax() {
        $labels = array(
            'name'              => _x( 'Categories', 'taxonomy general name' ),
            'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
            'menu_name'         => __( 'Categories' )
        );
        $this->register_taxonomy('my_posts','posts_categories', $labels);
    }

    /**
     * @param $post_name
     * @param $label
     * @param array $new_labels
     * @param null $icon
     * @param int $position
     *
     * @icon-reference: https://developer.wordpress.org/resource/dashicons/#desktop
     */
    private function register_post($post_name, $label, $new_labels = array(), $icon = null, $position = 20) {
        $labels = array(
            'name'                  => _x( 'Name', 'Post Type General Name', 'sitedomain' ),
            'singular_name'         => _x( 'Single Name', 'Post Type Singular Name', 'sitedomain' ),
            'menu_name'             => __( 'menu_name', 'sitedomain' ),
            'name_admin_bar'        => __( 'Admin bar name', 'sitedomain' ),
            'archives'              => __( 'Archives Name', 'sitedomain' ),
            'parent_item_colon'     => __( 'Parent Item:', 'sitedomain' ),
            'all_items'             => __( 'All Items', 'sitedomain' ),
            'add_new_item'          => __( 'Add New Item', 'sitedomain' ),
            'add_new'               => __( 'Add New', 'sitedomain' ),
            'new_item'              => __( 'New Item', 'sitedomain' ),
            'edit_item'             => __( 'Edit Item', 'sitedomain' ),
            'update_item'           => __( 'Update Item', 'sitedomain' ),
            'view_item'             => __( 'View Item', 'sitedomain' ),
            'search_items'          => __( 'Search Item', 'sitedomain' ),
            'not_found'             => __( 'Not found', 'sitedomain' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'sitedomain' ),
            'featured_image'        => __( 'Featured Image', 'sitedomain' ),
            'set_featured_image'    => __( 'Set featured image', 'sitedomain' ),
            'remove_featured_image' => __( 'Remove featured image', 'sitedomain' ),
            'use_featured_image'    => __( 'Use as featured image', 'sitedomain' ),
            'insert_into_item'      => __( 'Insert into item', 'sitedomain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'sitedomain' ),
            'items_list'            => __( 'Items list', 'sitedomain' ),
            'items_list_navigation' => __( 'Items list navigation', 'sitedomain' ),
            'filter_items_list'     => __( 'Filter items list', 'sitedomain' ),
        );
        // override names
        foreach($new_labels as $key => $l) {
            $labels[$key] = $l;
        }
        $args = array(
            'label'                 => __( $label, 'sitedomain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'page-attributes', ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'menu_position'         => $position,
            'menu_icon'             => $icon,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page'
        );
        register_post_type( $post_name, $args );
    }

    /**
     * @param $post_name
     * @param $tax_slug
     * @param $new_labels
     */
    private function register_taxonomy($post_name, $tax_slug, $new_labels) {
        $labels = array(
            'name'              => _x( 'Categories', 'taxonomy general name' ),
            'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Items' ),
            'all_items'         => __( 'All Items' ),
            'parent_item'       => __( 'Parent Item' ),
            'parent_item_colon' => __( 'Parent Item:' ),
            'edit_item'         => __( 'Edit Item' ),
            'update_item'       => __( 'Update Item' ),
            'add_new_item'      => __( 'Add New Item' ),
            'new_item_name'     => __( 'New Item Name' ),
            'menu_name'         => __( 'Categories' ),
        );
        // override names
        foreach($new_labels as $key => $l) {
            $labels[$key] = $l;
        }
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_menu'      =>  true,
            'rewrite'           => array( 'slug' => $tax_slug ),
        );
        register_taxonomy( $tax_slug, array( $post_name ), $args );
    }

    public function remove_menu_pages() {
        remove_menu_page( 'edit.php?post_type=pages' );
    }
}