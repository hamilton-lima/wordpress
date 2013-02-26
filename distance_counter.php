<?php
/*
Plugin Name: Distance Counter
Plugin URI: http://athanazio.com
Description: Soma valores do campo customizado "distance"
Version: 1.0
Author: athanazio
Author URI: http://www.athanazio.com
*/
 
add_action('widgets_init', create_function('',
    'return register_widget("DistanceCounter");'));
 
class DistanceCounter extends WP_Widget {
 
    function __construct(){
        $options = array(
            'description' => 'Distance Counter',
            'name' => 'Distance Counter'
        );
        parent::__construct('DistanceCounter','',$options);
    }
 
    public function form( $instance ) {
 
        extract($instance);
        ?>
        <p>
        <label for="">Title: </label>
        <input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id('title');?>" 
        name="<?php echo $this->get_field_name('title');?>" value="<?php if(isset($title)) echo esc_attr($title);?>"/>
        </p>
 
        <?php
    }
 
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }
 
    public function widget( $args, $instance ) {
 
        extract( $args );
 
        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title'] );
 
        /* Before widget (defined by themes). */
        echo $before_widget;
 
        /* Title of widget (before and after defined by themes). */
        if ( $title ){
            echo $before_title . $title . $after_title;
        }
 
        $distance = array();
        $meta_key = 'distance';
 
        global $wpdb;
 
        $distance = $wpdb->get_col(
            $wpdb->prepare(
            "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s",
                $meta_key));
 
        echo '<ul><li> '.array_sum( $distance ). ' km percorridos</li>'
        .'<li><a href="/category/duplas-aventuras/">veja os relatos</a></li>'
        .'</ul>';
        echo $after_widget;
    }
 
}
 
?>