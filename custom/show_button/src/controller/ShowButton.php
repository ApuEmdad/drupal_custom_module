<?php

namespace Drupal\show_button\controller;

use Drupal\Core\Controller\ControllerBase;

class ShowButton extends ControllerBase
{

  public function view()
  {
    $content = [];
    $content['name'] = 'Ben Damptey';
    return [
      "#theme" => 'show-button',
      '#content' => $content,
    ];
  }
}
