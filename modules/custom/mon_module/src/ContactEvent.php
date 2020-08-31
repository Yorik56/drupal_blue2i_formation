<?php 

namespace Drupal\mon_module;

use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Config\Config;

class ContactEvent extends Event {

    protected $config;


    public function __construct(Config $config) {
        $this->config = $config;
    }

    public function getConfig() {
        return $this->config;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

}