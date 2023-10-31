<?php
/*
 * Plugin Name:       Events Listing Plugin
 * Description:       Project create an events listing plugin.
 * Version:           1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Brendan Morgan
 */

 if( ! defined ('ABSPATH') ) {
    die;
 }

class EventsListing {

    public function __construct()
    {
        //create custom post type
        add_action('init', array($this, 'custom_post_type'));

        //
        register_deactivation_hook(__FILE__, array($this, 'plugin_deactivate'));

        //adds meta boxes
        add_action('add_meta_boxes', array($this, 'add_post_meta_boxes'));

        add_action('save_post', array($this, 'save_post_meta_boxes'));

        //add assets (js,css,etc)
        add_action('wp_enqueue_scripts ', array($this, 'load_assets'));

        //add short code named listing-page
        add_shortcode('events-list', array($this,'load_shortcode'));

        add_action('wp_footer', array($this, 'load_scripts'));

    }

    public function plugin_deactivate()
    {
        flush_rewrite_rules();
        global $wpdb;
        $wpdb -> query( "DELETE FROM wp_posts WHERE post_type = 'events_listing' " );
    }

    public function custom_post_type()
    {
        $args = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'revisions'), 
            'publicaly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'can_export' => true,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'Event',
                'singular' => 'Event',
                'item_published' => 'event published'
            ),
            'menu_icon' => 'dashicons-calendar'
        );

        //name of our post type
        register_post_type('events_listing', $args);
    }

    public function add_post_meta_boxes(){

        add_meta_box(
            'post_metadata_events_post', //unique id given to each meta box
            'Event Date', //title of meta box
            array($this, 'post_meta_box_events_post'), //callback function that outputs the markup inside the custom meta box
            'events_listing', //name of post type in which our meta box will be rendered 
            'side', //postion of the meta box on the screen
            'high' //placement priority
        );  

    }

    function post_meta_box_events_post(){

        global $post;
        $custom = get_post_custom( $post -> ID); 
        $fieldData = $custom["_event_date"][0];
        echo "<input type=\"date\" name=\"_event_date\" value=\"".$fieldData."\" placeholder=\"Event Date\">";
    }
    
    //save field value
    function save_post_meta_boxes(){

        global $post;
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
            return;
        }  
        update_post_meta($post->ID, "_event_date", sanitize_text_field($_POST["_event_date"]));

    }



    
        

    // public function load_assets()
    // {
    //     wp_enqueue_style(
    //         'style',
    //         get_template_directory_uri() . '/css/events-listing-wp-plugin.css',
    //         false,
    //         '1.1',
    //         'all'
    //     );

    //     wp_enqueue_script(
    //         'events-listing-wp-plugin',
    //          plugin_dir_url( __FILE__ ) . '/js/events-listing-wp-plugin.js'
    //         //  array('jquery'),
    //         //  1,
    //         //  true 
    //     ); 



    

    function load_shortcode(){

        global $post;
        $args = array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'post_per_page' => 50,
            'orderby' => 'meta_value',
            'meta_key' => 'start_date',
            'order' => 'ASC'
        );
        
        $query = new WP_Query($args);

        $content = '<ul>';

        if($query->have_posts()):

            while($query->have_posts()): 
                $query->the_post();
                $content.= '
                <li>
                    <a href="'.get_the_permalink().'">
                        '. get_the_title() .'
                    </a> - 
                    '.date_format(date_create(get_post_meta($post->ID, 'start_date', true)), 'jS F').'
                </li>
                ';
            endwhile;
 
        else:
            _e('Sorry nothing to display');
        endif;

        $content .= '</ul>';
    
        echo $content; 

    }
   

}

new EventsListing;