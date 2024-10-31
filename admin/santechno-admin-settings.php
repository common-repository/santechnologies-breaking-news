<?php
/*
 * All Admin settings goes here
 *
 */

/**
 * Add Custom post type here for breaking news
 * santechno_breaking_news
 */
require_once('Stbn-breaking-news.php');
function santechno_bn_post_type() {

    $labels = array(

        'menu_name' => _x('Breaking News', 'santechno_breaking_news'),

    );

    $args = array(

        'labels' => $labels,

        'hierarchical' => true,

        'description' => 'Breaking News',

        'supports' => array('title', 'editor'),

        'public' => true,

        'show_ui' => true,

        'show_in_menu' => true,

        'show_in_nav_menus' => true,

        'publicly_queryable' => true,

        'exclude_from_search' => false,

        'has_archive' => true,

        'query_var' => true,

        'can_export' => true,

        'rewrite' => true,

        'capability_type' => 'post'

    );

    register_post_type('santechno_breaking_news', $args);

}


/** Register the menu Breaking News Settings*/
add_action('admin_menu', 'stbn_plugin_settings');

function stbn_plugin_settings() {
    add_menu_page('SANTechno Breaking News', 'Breaking News Settings', 'administrator', 'stbn_settings', 'stbn_display_settings');
}

/** Create Html Page for the settings */
function stbn_display_settings() {


    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );

    $stbn_enabled  = (get_option('stbn_enabled') == 'enabled') ? 'checked' : '' ;
    $stbn_prefix_text = (get_option('stbn_prefix_text') != '') ? get_option('stbn_prefix_text') : 'Breaking News';
    $stbn_position_header = (get_option('stbn_position') == 'header') ? 'selected' : '';
    $stbn_position_footer = (get_option('stbn_position') == 'footer') ? 'selected' : '';
    $stbn_alignment_ltr = (get_option('stbn_alignment') == 'ltr') ? 'selected': 'ltr';
    $stbn_alignment_rtl = (get_option('stbn_alignment') == 'rtl') ? 'selected': 'rtl';
    $stbn_title_color = (get_option('stbn_title_color') != '') ? get_option('stbn_title_color') : '#dd3333';
    $stbn_title_color_2 = (get_option('stbn_title_color_2') != '') ? get_option('stbn_title_color_2') : '#dd3333';
    $stbn_title_text_color = (get_option('stbn_title_text_color') != '') ? get_option('stbn_title_text_color') : '#000000';
    $stbn_newsbar_color = (get_option('stbn_newbar_color') != '') ? get_option('stbn_newbar_color') : '#000000';
    $stbn_newsbar_color_2 = (get_option('stbn_newbar_color_2') != '') ? get_option('stbn_newbar_color_2') : '#000000';
    $stbn_newsbar_text_color = (get_option('stbn_newbar_text_color') != '') ? get_option('stbn_newbar_text_color') : '#ffffff';
    $stbn_newsbar_opacity = (get_option('stbn_opacity') != '') ? get_option('stbn_opacity') : '0.8';

    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>Breaking News Settings</h2>' . wp_nonce_field('update-options') . '
            <table width="100%" cellpadding="15" class="form-table">
                <tr>
                    <td align="left" scope="row">
                        <label>Enable Breaking News </label>
                        <input type="checkbox" '.$stbn_enabled.' name="stbn_enabled" value="enabled" />
                        <small>Check to enable</small>
                    </td>
                </tr>
                  <tr>
                    <td align="left" scope="row">
                        <label>Text</label>
                        <input type="text" name="stbn_prefix_text" value="' . $stbn_prefix_text . '" />
                        <small>(Default is "Breaking News")</small>
                </td>
                <tr>
                    <td align="left" scope="row">
                        <label>Alignment</label>
                        <select name="stbn_alignment" >
                          <option value="ltr" ' . $stbn_alignment_ltr . '>LTR</option>
                          <option value="rtl" '.$stbn_alignment_rtl.'>RTL</option>
                        </select>
                        <small> (RTL or LTR - Default is LTR)</small>
                    </td>
                </tr>
                 <tr>
                    <td align="left" scope="row">
                        <label>Position</label>
                        <select name="stbn_position" >
                          <option value="header" ' . $stbn_position_header . '>Top</option>
                          <option value="footer" '.$stbn_position_footer.'>Bottom</option>
                        </select>
                        <small> (show in the footer or top of the page)</small>
                    </td>
                </tr>
                <tr>
                    <td>
                         <label>Pick Title Bg Color: </label>
                         <input name="stbn_title_color" type="text" id="stbn_title_color" value="'.$stbn_title_color.'" data-default-color="#ffffff">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    $("#stbn_title_color").wpColorPicker();
                                });
                        </script>
                        <small>Default is red (#dd3333)</small>
                        <label>Pick Title Bg Color2 for gradent: </label>
                         <input name="stbn_title_color_2" type="text" id="stbn_title_color_2" value="'.$stbn_title_color_2.'" data-default-color="#ffffff">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    $("#stbn_title_color_2").wpColorPicker();
                                });
                        </script>
                        <small>Default is red (#dd3333)</small>
                    </td>
                </tr>
                <tr>
                    <td>
                         <label>Pick Title text Color: </label>
                         <input name="stbn_title_text_color" type="text" id="stbn_title_text_color" value="'.$stbn_title_text_color.'" data-default-color="#ffffff">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    $("#stbn_title_text_color").wpColorPicker();
                                });
                        </script>
                        <small>Default is red (#dd3333)</small>
                    </td>
                </tr>


                <tr>
                    <td>
                         <label>News Bar Color: </label>
                         <input name="stbn_newbar_color" type="text" id="stbn_newbar_color" value="'.$stbn_newsbar_color.'" data-default-color="#000000">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    $("#stbn_newbar_color").wpColorPicker();
                                });
                        </script>
                        <small>Default is black (#000000)</small>
                         <label>News Bar Color2 for gradent: </label>
                         <input name="stbn_newbar_color_2" type="text" id="stbn_newbar_color_2" value="'.$stbn_newsbar_color_2.'" data-default-color="#000000">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    $("#stbn_newbar_color_2").wpColorPicker();
                                });
                        </script>
                        <small>Default is black (#000000)</small>
                    </td>
                </tr>
                <tr>
                    <td>
                         <label>News Bar Text Color: </label>
                         <input name="stbn_newbar_text_color" type="text" id="stbn_newbar_text_color" value="'.$stbn_newsbar_text_color.'" data-default-color="#ffffff">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    $("#stbn_newbar_text_color").wpColorPicker();
                                });
                        </script>
                        <small>Default is red (#dd3333)</small>
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                        <label>News Bar Opacity </label>
                        <input type="text" name="stbn_opacity" value="' . $stbn_newsbar_opacity . '" />
                        <small>(Choose Value between 0.1 - , 1 is no opacity. Default is 0.8)</small>
                </td>
                </tr>
            </table>
            <p class="submit">
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="stbn_enabled,stbn_prefix_text,stbn_alignment,stbn_position,stbn_title_color,stbn_title_color_2,stbn_title_text_color,stbn_newbar_color,stbn_newbar_color_2,stbn_newbar_text_color,stbn_opacity" />
                <input type="submit" name="Submit" value="Save Settings" />
            </p>
            </form>

        </div>';
    echo $html;
}
