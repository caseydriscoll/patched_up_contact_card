<?php 

/* Plugin Name: Patched Up Contact Card 
 * Plugin URI: http://patchedupcreative.com/plugins/contact-card
 * Description: A very clean and semantic way of adding social networking links to your sidebar
 * Version: 0.0.2
 * Date: 10-04-2013
 * Author: Casey Patrick Driscoll
 * Author URI: http://caseypatrickdriscoll.com
 *
 * In This File:
 *    The widget class with the four horesmen of WordPress Widgets:
 *      __construct()
 *      widget()
 *      form()
 *      update()
 *
 *    Important registration and action filters at the end of the file.
 *
 * How It Works:
 *
 *
 * Copyright:
 *    Copyright 2013 Casey Patrick Driscoll (email: caseypatrickdriscoll@me.com)
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License, version 2, as
 *    published by the Free Software Foundation.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

Class Patched_Up_Contact_Card_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'patched_up_contact_card',
      'Contact Card',
      array( 'description' => __( 'A list of all your social network profiles and means of contact', 'text_domain' ) )
    );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title']);

    echo $args['before_widget'];

    // If there is a title, print it out
    if ( !empty($title) )
      echo $args['before_title'] . $title . $args['after_title'];

    echo $args['after_widget'];
  }

  public function form( $instance ) {
    // Grab the existing variables if they exist
    if ( isset($instance) ) extract($instance);

    ?>

    <p><?php // Standard Title Form ?>
      <label for="<?php echo $this->get_field_id('title');?>">Title:</label>
        <input  type="text"
                class="widefat"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php if ( isset($title) ) echo esc_attr($title); ?>" />
    </p>

    <?
  }

  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;

    // Fields
    $instance['title'] = strip_tags($new_instance['title']);

    return $instance;
  }
}

function register_patched_up_contact_card_widget() {
  register_widget( 'Patched_Up_Contact_Card_Widget' );
}
add_action( 'widgets_init', 'register_patched_up_contact_card_widget' );
