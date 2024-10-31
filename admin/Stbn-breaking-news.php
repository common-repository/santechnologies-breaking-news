<?php
/**
 * Santechno Breaking News
 * by SAN Technologies
 * santechno.net
 *
 */

if ( !class_exists( 'WP_Stack_Plugin' ) ) {
    class WP_Stack_Plugin {
        public function hook( $hook ) {
            $priority = 10;
            $method = $this->sanitize_method( $hook );
            $args = func_get_args();
            unset( $args[0] );
            foreach( (array) $args as $arg ) {
                if ( is_int( $arg ) )
                    $priority = $arg;
                else
                    $method = $arg;
            }
            return add_action( $hook, array( $this, $method ), $priority, 999 );
        }

        private function sanitize_method( $method ) {
            return str_replace( array( '.', '-' ), array( '_DOT_', '_DASH_' ), $method );
        }
    }
}
class Stbn_breaking_news extends  WP_Stack_Plugin{

    public static $instance;
    const MY_TEXT_DOMAIN = 'stbn-breaking-news';

    public function __construct() {
        self::$instance = $this;
        $this->hook( 'init' );
    }

    public function init() {

        load_plugin_textdomain( self::MY_TEXT_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages' );

        $this->hook( 'add_meta_boxes' );
        $this->hook( 'save_post' );
        $this->hook( 'wp_head' );

    }

    public function add_meta_boxes( $post_type ) {
        add_meta_box(
            'breaking_news_meta_box','Breaking News', array(
                $this,
                'stbn_news_meta_box'
            ), 'post', 'normal', 'high'
        );
    }

    public function stbn_news_meta_box( $post ) {

        $stbn_is_enbaled  = esc_html(get_post_meta( $post->ID, 'stbn_is_enabled', true ));
        $stbn_interval    = esc_html(get_post_meta( $post->ID, 'stbn_interval', true ));

        $html = '<table>
            <tr>
                <td><label>Is Breaking News? </label></td>
                <td>
                    <input type="radio" name="stbn_is_enabled"'. checked( $stbn_is_enbaled, '1' ).' value="1">Yes
                    <input type="radio" name="stbn_is_enabled" '. checked( $stbn_is_enbaled, '0' ).' value="0">No
                </td>
            </tr>
            <tr>
                <td><label>Select Time to show:</label></td>
                <td>
                    <input type="text" name="stbn_interval" value="' . $stbn_interval . '" />
                    <small>To be shown as Breaking news for how many hr(s), Default is 2 hrs</small>
                </td>
            </tr>
        </table>';
        echo $html;

    }

    public function save_post( $post_id ) {
        if ( isset( $_POST['stbn_is_enabled'] ) && $_POST['stbn_is_enabled'] != '' ) {
            update_post_meta( $post_id, 'stbn_is_enabled', $_POST['stbn_is_enabled'] );
        }
        if ( isset( $_POST['stbn_interval'] ) && $_POST['stbn_interval'] != '0' ) {
            update_post_meta( $post_id, 'stbn_interval', $_POST['stbn_interval'] );
        }
    }

    public function wp_head($limit = 1, $chars = 0,$tag_id = 0){
        global $wpdb,$post;

        $most_viewed = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.* FROM $wpdb->posts LEFT JOIN $wpdb->postmeta
                        ON $wpdb->postmeta.post_id = $wpdb->posts.ID
                        WHERE post_date < '".current_time('mysql')."'
                        AND post_status = 'publish'
                        AND meta_key = 'stbn_is_enabled'
                        AND meta_value = '1'
                        AND post_password = '' ORDER BY $wpdb->postmeta.post_id DESC LIMIT 1");

        if($most_viewed) {
            foreach ($most_viewed as $post) {
                $post_title = get_the_title($post);
                //echo $post_title;
            }
        }
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );

        $stbn_enabled  = (get_option('stbn_enabled') == 'enabled') ? 'checked' : '' ;
        $stbn_prefix_text = (get_option('stbn_prefix_text') != '') ? get_option('stbn_prefix_text') : 'Breaking News';
        $stbn_position_header = (get_option('stbn_position') == 'header') ? 'selected' : '';
        $stbn_position_footer = (get_option('stbn_position') == 'footer') ? 'selected' : '';

        if ( $post && $post->post_type == 'post' && $stbn_enabled == 'checked') {

            $stbn_is_enbaled = get_post_meta( $post->ID, 'stbn_is_enabled', true );
            $stbn_interval   = get_post_meta( $post->ID, 'stbn_interval', true );

            $post_time    = $post->post_date;
            $expire_time  = strtotime( '+' . $stbn_interval . ' hour', strtotime( $post_time ) );

            $current_time = current_time( 'timestamp' );

            if ( $stbn_is_enbaled === '1' && ( $expire_time > $current_time )  && $stbn_position_header == 'selected') {

                echo '<div class="stbn-breaking-news-header"><div class="col-xs-12 col-md-1 stn-bn-prefix" >'.$stbn_prefix_text .'</div><div class="col-xs-12 col-md-11 stn-news-bar"><a href="'.$post->guid.'">'.$post->post_title.'</a> <span class="stbn-close-btn" style="cursor:pointer">ClOSE</span></div></div>';


            }else if ( $stbn_is_enbaled === '1' && ( $expire_time > $current_time )  && $stbn_position_footer == 'selected') {
                echo '<div class="stbn-breaking-news-footer" id="stbn-footer"><div class="col-xs-12 col-md-1 stn-bn-prefix" >'.$stbn_prefix_text .'</div><div class="col-xs-12 col-md-11 stn-news-bar"><a href="'.$post->guid.'">'.$post->post_title.'</a> <span class="stbn-close-btn" style="cursor:pointer">ClOSE</span></div></div>';
            }else{
                echo '';
            }
        }

    }


}


new Stbn_breaking_news;

