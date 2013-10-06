<?php

Class Patched_Up_Contact_Card {
  private $contact_card;

  public function __construct($instance) {
    $this->contact_card = $this->build_card($instance);
  }

  public function __toString() {
    return $this->contact_card;
  }

  private function build_card($instance){
    extract($instance); // Extacts to $title, $count, $platform_# and $username_#

    /* 1.0 CONSTRUCT THE CONTACT CARD HTML */
    // Quick contact information about this plugin
    $contact_card  = '<!-- Patched Up Contact Card by Casey Patrick Driscoll of Patched Up Creative 2013 -->';
    $contact_card .= '<!--   caseypatrickdriscoll.com  ---  patchedupcreative.com/plugins/contact-card   -->';

    // The contact card is a simple unordered list
    $contact_card .= '<ul class="patched_up_contact_card">';
    
    // Grab the count in the $instance variable and add each platform and username into a link
    for( $i = 0; $i < $count; $i++ ) {
      $platform = 'platform_' . $i;
      $username = 'username_' . $i;
  
      $contact_card .= '<li><a href="http://' . $$platform . '.com/' .$$username . '" class="icon-' . $$platform .'" target="_blank"></a></li>';
    }

    $contact_card .= '</ul>';
    
    return $contact_card;

  }
}
