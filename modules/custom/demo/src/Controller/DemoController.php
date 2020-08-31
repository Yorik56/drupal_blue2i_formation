<?php

namespace Drupal\demo\Controller;

use Drupal\Core\Controller\ControllerBase;

class DemoController extends \Drupal\Core\Controller\ControllerBase {

    public function description() {
        $build = array(
            '#type' => 'markup',
            '#markup' => t('Hello world !'),
        );

        return $build;
    }
}