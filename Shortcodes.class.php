<?php

final class Shortcodes {

    public function __construct() {
        add_shortcode( 'post', array($this, 'custom_post'));
        add_shortcode( 'submit_question', array($this, 'submit_question'));
    }

    public function custom_post( $args ) {

        $args = shortcode_atts( array(
            'type' => '',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'date',
            'class' => '',
            'fullwidth' => true,
            'id' => '',
            'cols' => 3,
            'category' => '',
        ), $args );

        return $this->get_template_html($args['type'], $args);
    }

    public function submit_question( $args ) {
        $args = shortcode_atts( array(), $args );
        return $this->get_template_html('submit_question', $args);
    }


    /**
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $template_name The name of the template to render (without .php)
     * @param array  $attributes    The PHP variables for the template
     *
     * @return string               The contents of the template.
     */
    private function get_template_html( $template_name, $attributes = null ) {
        if ( ! $attributes ) {
            $attributes = array();
        }
        extract($attributes);

        $args = get_posts_by_type();
        extract($args);

        ob_start();
        if(file_exists(__DIR__.'/templates/' . $template_name . '.php'))
            require( 'templates/' . $template_name . '.php');
        else
            require( 'templates/template.php');
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}