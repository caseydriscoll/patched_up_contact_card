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

      if     ($$platform == 'skype')         $url = $$platform . ':' . $$username . '?call'; 
      elseif ($$platform == 'google-plus')   $url = 'http://plus.google.com/' . $$username; 
      elseif ($$platform == 'steam')         $url = 'http://steamcommunity.com/id/' . $$username; 
      elseif ($$platform == 'linkedin')      $url = 'http://www.' . $$platform . '.com/in/' . $$username; 
      elseif ($$platform == 'envelope')      $url = 'mailto:' . $$username; 
      elseif ($$platform == 'tumblr')        $url = 'http://' . $$username . '.' . $$platform . '.com'; 
      elseif ($$platform == 'blogger')       $url = 'http://' . $$username . '.blogspot.com'; 
      elseif ($$platform == 'wordpress')     $url = 'http://' . $$username . '.' . $$platform . '.com'; 
      elseif ($$platform == 'flickr')        $url = 'http://' . $$platform . '.com/photos/' . $$username; 
      elseif ($$platform == 'stumbleupon')   $url = 'http://' . $$platform . '.com/stumbler/' . $$username; 
      elseif ($$platform == 'stackoverflow') $url = 'http://' . $$platform . '.com/users/' . $$username; 
      elseif ($$platform == 'reddit')        $url = 'http://www.' . $$platform . '.com/user/' . $$username;
      elseif ($$platform == 'youtube')       $url = 'http://www.' . $$platform . '.com/user/' . $$username;
      elseif ($$platform == 'screen')        $url = 'http://' . $$username;
      elseif ($$platform == 'phone')         $url = '/' . $$username;
      elseif ($$platform == 'mobile')        $url = '/' . $$username;
      elseif ($$platform == 'feed')          $url = 'feed';
      else                                   $url = 'http://' . $$platform . '.com/' . $$username;
  
      $contact_card .= '<li>' .
                          '<a href="' . $url . '" 
                              class="icon-' . $$platform .'" 
                              target="_blank">' .
                          '</a>' .
                       '</li>';
    }

    $contact_card .= '</ul>';
    
    return $contact_card;

  }
}
