<?php

namespace Drupal\mon_module\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\mon_module\ContactEvent;

class MonmoduleConfigForm extends ConfigFormBase {
    public function getFormId() {
        return 'config_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $config = $this->config('mon_module.config_form');

        $form['store_name'] = array (
            '#type' => 'textfield',
            '#title' => $this->t('Store name') ,
            '#default_value' => $config->get('store_name') ,
        );

        $form['opening_time'] = array (
            '#type' => 'textarea',
            '#title' => $this->t('Opening time') ,
            '#default_value' => $config->get('opening_time') ,
        );

        return parent::buildForm($form, $form_state);
        
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

        parent::submitForm($form, $form_state);

        $config = $this->config('mon_module.config_form');
        $config->set('store_name', $form_state->getValue('store_name'))
               ->set('opening_time', $form_state->getValue('opening_time'));

        $dispatcher = \Drupal::service('event_dispatcher');
        $e = new ContactEvent($config);
        $event = $dispatcher->dispatch('contact_form.save', $e);

        $data = $event->getConfig()->get();
        $config->merge($data);
        
        $config->save();
    }

    protected function getEditableConfigNames(){
        return array(
            'mon_module.config_form'
        );
    }
}