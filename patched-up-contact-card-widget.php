<?php 

/* Plugin Name: Patched Up Contact Card 
 * Plugin URI: http://patchedupcreative.com/plugins/contact-card
 * Description: A very clean and semantic way of adding social networking links to your sidebar
 * Version: 0.0.3
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
 *    The all variables are saved in the $instance variable. Each social button is saved as a key => value
 *    labelled 'platform_#' and 'username_#'
 *
 *    A count is retained in the instance and a for loop can easily grab every key/value through iteration.
 *
 *    Simple validation occurs in update(), not saving the values if they are default and returning an alert
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
  private $debug = false;

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
    if($this->debug) print_r($instance);

    // Grab the existing variables if they exist
    if ( isset($instance) ) extract($instance);

    ?>

    
    <?php // A quick and dirty alert box if the user doesn't update anything but hits save 
    if( $alert != '' ) 
    echo '<p style="color:red;padding:5px;border:1px solid red;border-radius:5px;background-color:rgba(255,0,0,0.2);">' . $alert . '</p>'; ?>

    <p><?php // Standard Title Form ?>
      <label for="<?php echo $this->get_field_id('title');?>">Title:</label>
        <input  type="text"
                class="widefat"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php if ( isset($title) ) echo esc_attr($title); ?>" />
    </p>

    <?php   // Button Fields: Pairs of urls and usernames 
            //   There will be a select list with every available platform ?>

    <?php if ( !isset($count) ) $count = 0;

          $options = array( // To populate every select list below
              "Add new:"  => "",
              "facebook"  => "http://facebook.com/",
              "twitter"   => "http://twitter.com/",
              "skype"     => "skype:",
              "linkedin"  => "http://linkedin.com/",
              "reddit"    => "http://reddit.com/u/",
              "github"    => "http://github.com/",
          );

    // For every platform given through $instance
    //    Key => Value pairs are simply stored as 'platform_#' and 'username_#'. Set debug to true for more info
    for ( $i = 0; $i <= $count; $i++ ) { 
        $platform_count = 'platform_' . $i; // the platform key for this button 
        $username_count = 'username_' . $i; // the username key for thie button
      
      // Every button is a paragraph with two inputs: a selector for the platform and an input for username ?>
      <p style="clear:both;padding-bottom:10px;height:10px;">
        <select name="<?php echo $this->get_field_name($platform_count); ?>" 
                id="<?php echo $this->get_field_id($platform_count); ?>"
                style="width: 100px; float: left;"
                class="">

        <?php foreach ($options as $option => $url) // Add every option to the dropdown as given above 
        echo '<option value="' . $url . '" id="' . $option . '"' , 
               $count != $i && $$platform_count == $url ? ' selected="selected"' : '', '>' .
                ucfirst($option) . 
             '</option>'; ?>
        </select>

        <input  type="text" <?php // The input text field for the username ?>
                style="width: 120px; float: left;"
                class=""
                id="<?php echo $this->get_field_id($username_count); ?>"
                name="<?php echo $this->get_field_name($username_count); ?>"
                value="<?php echo isset($$username_count) ? esc_attr($$username_count) : 'User ID' ?>" />
      </p>

    <? } ?>

        <input type="hidden" <?php // A simple hidden field to carry along the total number of contact buttons?>
             id="<?php echo $this->get_field_id('count');?>" 
             name="<?php echo $this->get_field_name('count');?>" 
             value="<?php echo $count + 1; ?>">

    <?
  }

  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;

    // Fields
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['count'] = strip_tags($new_instance['count']);

    for ($count = 0; $count < $instance['count']; $count++) {
      // Simple validation does not save if defaults are given and returns an error alert
      if ( $new_instance['platform_' . $count] != '' && $new_instance['username_' . $count] != 'User ID') {
        $instance['platform_' . $count] = strip_tags($new_instance['platform_' . $count]);
        $instance['username_' . $count] = strip_tags($new_instance['username_' . $count]);
        $instance['alert'] = '';
      } else {
        $instance['count'] = $instance['count'] - 1;
        $instance['alert'] = "Must select a platform and enter a username";
      }
    }
    return $instance;
  }
}

function register_patched_up_contact_card_widget() {
  register_widget( 'Patched_Up_Contact_Card_Widget' );
}
add_action( 'widgets_init', 'register_patched_up_contact_card_widget' );
