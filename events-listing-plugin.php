<?php
/*
 * Plugin Name:       Events Listing Plugin
 * Description:       Project to create an events listing plugin.
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

        add_action('admin_init', 'add_post_meta_boxes');

        //add assets (js,css,etc)
        add_action('wp_enqueue_scripts ', array($this, 'load_assets'));

        //add short code named listing-page
        add_shortcode('listing-page', array($this,'load_shortcode'));

        add_action('wp_footer', array($this, 'load_scripts'));
    }

    public function custom_post_type()
    {
        $args = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions'), 
            'exclude_from_search' => true,
            'publicaly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'Events',
                'singular' => 'Contact Form Entry',
                'item_published' => 'event published'
            ),
            'menu_icon' => 'dashicons-calendar'
        );

        register_post_type(' ', $args);
    }

    function add_post_meta_boxes(){

        add_meta_box(
            'post_metadata_events_post', 
            'Event_Date', 
            'post_meta_box_events_post',
            'events_listing',
            'side', 
            'low'
        );

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



    // }

    public function load_shortcode()
    {?>
        <div>

            <h1>Send us an email</h1>
            <p>Please Fill the below form</p>

            <form id="contact-form_form">

                <div class="form-group mb-2">
                    <input name="name" type="text" placeholder="Name" class="form-control">
                </div>

                <div class="form-group mb-2">
                    <input name="email" type="email" placeholder="Email" class="form-control">
                </div>

                <div class="form-group mb-2">
                    <input name="phone" type="tel" placeholder="Phone" class="form-control">
                </div> 

                <div class="form-group mb-2">
                    <textarea name="message" placeholder="Type your message" class="form-control"></textarea> 
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block w-100 ">Send Message</button>
                </div>

            </form>

        </div>

    <?php }

    function load_scripts()
    {?>
         <!-- <script>
            alert ("it works")
         </script> -->

    <?php }


}

new EventsListing;