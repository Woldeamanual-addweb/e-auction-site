<?php

/**
 * @file
 * Contains \Drupal\movielisting\Form\MovieAPI
 */

namespace Drupal\movielisting\Form;

use Drupal\Core\Form\FormBase;

use Drupal\Core\Form\FormStateInterface;

class MovieAPI extends FormBase
{
    const MOVIE_API_CONFIG_PAGE = 'movie_api_config_page:values';

    public function getFormId()
    {
        return 'movie_api_config_pagge';
    }


    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = [];
        $form['bid'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Place Bid'),
            '#required' => TRUE,


        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Place Bid'),
            '#button_type' => 'primary'
        ];

        return $form;
    }


    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $submitted_values = $form_state->cleanValues()->getValues();

        // \Drupal::state()->set(self::MOVIE_API_CONFIG_PAGE, $submitted_values);

        $messenger = \Drupal::service('messenger');
        $messenger->addMessage($this->t('Your new configuration has been saved.'));
    }
}
