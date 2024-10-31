<?php
/**
 * Add Scripts and stylesheet necessary
 * santechno_breaking_news
 */
add_action('wp_enqueue_scripts', 'stbn_scripts');

function stbn_scripts() {
    global $post;
    wp_enqueue_script('jquery');
}

// load twitter bootstrap

if (!is_admin()) {

    // Load CSS
    add_action('wp_enqueue_scripts', 'twbs_load_styles', 11);
    function twbs_load_styles() {
        // Bootstrap
        wp_register_style('bootstrap-styles', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css', array(), null, 'all');
        wp_enqueue_style('bootstrap-styles');
        // Theme Styles
        wp_register_style('theme-styles', get_stylesheet_uri(), array(), null, 'all');
        wp_enqueue_style('theme-styles');
        // Font Awesome
        wp_register_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css', array(), null, 'all');
        wp_enqueue_style('font-awesome');
    }

    // Load Javascript
    add_action('wp_enqueue_scripts', 'twbs_load_scripts', 12);
    function twbs_load_scripts() {
        // jQuery
        wp_deregister_script('jquery');
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), null, false);
        wp_enqueue_script('jquery');
        // Bootstrap
        wp_register_script('bootstrap-scripts', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array('jquery'), null, true);
        wp_enqueue_script('bootstrap-scripts');
    }

} // end if !is_admin
add_action('wp_enqueue_scripts', 'stbn_styles');

function stbn_styles() {

    wp_enqueue_script('jquery');
    wp_register_style('stn_breaking_news', plugins_url('css/breaking-news.css', __FILE__));
    wp_enqueue_style('stn_breaking_news');
    wp_register_style('stn_breaking_news_custom', plugins_url('css/custom.css', __FILE__));
    wp_enqueue_style('stn_breaking_news_custom');
    wp_register_script('stbn_sticky', plugins_url('js/jquery.sticky.js', __FILE__), array("jquery"));
    wp_enqueue_script('stbn_sticky');
    wp_register_script('stbn_breaking_news_include', plugins_url('js/stbn-breaking-news.js', __FILE__), array("jquery"));
    wp_enqueue_script('stbn_breaking_news_include');

    $stbn_alignment_ltr = (get_option('stbn_alignment') == 'ltr') ? 'selected': 'ltr';
    $stbn_alignment_rtl = (get_option('stbn_alignment') == 'rtl') ? 'selected': 'rtl';
    $stbn_title_color = (get_option('stbn_title_color') != '') ? get_option('stbn_title_color') : '#dd3333';
    $stbn_title_color_2 = (get_option('stbn_title_color_2') != '') ? get_option('stbn_title_color_2') : '#dd3333';
    $stbn_title_text_color = (get_option('stbn_title_text_color') != '') ? get_option('stbn_title_text_color') : '#000000';
    $stbn_newsbar_color = (get_option('stbn_newbar_color') != '') ? get_option('stbn_newbar_color') : '#000000';
    $stbn_newsbar_color_2 = (get_option('stbn_newbar_color_2') != '') ? get_option('stbn_newbar_color_2') : '#000000';
    $stbn_newsbar_text_color = (get_option('stbn_newbar_text_color') != '') ? get_option('stbn_newbar_text_color') : '#ffffff';
    $stbn_newsbar_opacity = (get_option('stbn_opacity') != '') ? get_option('stbn_opacity') : '0.8';


    // The path where the custom.css should be stored.
    $str_custom_path =  dirname( __FILE__ ) . '/css/custom.css';

    if(is_writable( $str_custom_path)) {

        $css = '.stn-bn-prefix{background-image:-webkit-linear-gradient(bottom,'.$stbn_title_color.','.$stbn_title_color_2.');
background-image: -moz-linear-gradient(bottom,'.$stbn_title_color.','.$stbn_title_color_2.');
background-image: -ms-linear-gradient(bottom,'.$stbn_title_color.','.$stbn_title_color_2.');
background-image: -o-linear-gradient(bottom,'.$stbn_title_color.','.$stbn_title_color_2.');color:'.$stbn_title_text_color.';}';
        $css .= '.stn-news-bar{background-image:-webkit-linear-gradient(bottom,'.$stbn_newsbar_color.','.$stbn_newsbar_color_2.');
background-image: -moz-linear-gradient(bottom,'.$stbn_newsbar_color.','.$stbn_newsbar_color_2.');
background-image: -ms-linear-gradient(bottom,'.$stbn_newsbar_color.','.$stbn_newsbar_color_2.');
background-image: -o-linear-gradient(bottom,'.$stbn_newsbar_color.','.$stbn_newsbar_color_2.');color:'.$stbn_newsbar_text_color.';}';
        $css .= '.stn-news-bar{opacity: '.$stbn_newsbar_opacity.'}';

        file_put_contents( $str_custom_path, $css );
    } // end if

}
