<?php

namespace Drupal\mon_module\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

class ContactForm extends FormBase {

    public function getFormId(){
        return 'contact_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        
        $form = array();

        $form['contact_title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#maxlength' => 255,
            '#default_value' => '',
            '#required' => FALSE,
        );

        $form['contact_email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#description' => $this->t('Entrez une adresse mail valide'),
            '#default_value' => '',
            '#required' => TRUE,
        );

        $form['contact_message'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Your message'),
            '#description' => $this->t('Please add "Drupal" in this message'),
            '#default_value' => '',
            '#required' => TRUE,
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Submit'),
        );

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        // dsm($form_state->getValues());

        // Envoyer email
        $email_value = $form_state->getValue('contact_email');
        $msg = 'Votre email a bien été envoyé. Vous avez reçu une confirmation à ' . $email_value;

        drupal_set_message($msg);
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $msg_value = $form_state->getValue('contact_message');

        if (!strpos($msg_value, 'Drupal')) {
            $form_state->setErrorByName('contact_message', $this->t('Please add "Drupal" in this message'));
        }

    }

}