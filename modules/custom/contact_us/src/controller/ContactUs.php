<?php

namespace Drupal\contact_us\controller;

use Drupal\Core\Controller\ControllerBase;

class ContactUs extends ControllerBase
{

  public function view()
  {
    $content = [];
    $content['name'] = 'Ben Damptey';
    return [
      "#theme" => 'contact-us',
      '#content' => $content,
    ];
  }
}
