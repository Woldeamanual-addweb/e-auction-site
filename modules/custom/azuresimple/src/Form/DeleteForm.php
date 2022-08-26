<?php

/**
 * @file
 * Contains \Drupal\azuresimple\Form\DeleteForm
 */

namespace Drupal\azuresimple\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides Delete Bid Form.
 */

class DeleteForm extends FormBase
{
    /**
     * (@inheritDoc)
     */
    public function getFormId()
    {
        return 'delete_bid_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form = [];
         if(!\Drupal::currentUser()->isAuthenticated()){
            return $form;
        }
        if ($node->get('field_dea')->value - microtime(True) < 0) {
            $messenger = \Drupal::service('messenger');
            $messenger->addMessage($this->t('Auction is Over '));

            return $form;
        }
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Delete Bid'),
            '#button_type' => 'warning',
            '#attributes' => array('onclick' => 'if(!confirm("You sure ?")){return false;}')
        ]; 
      

        $form['nid'] = [
            '#type' => 'hidden',
            '#value' => $nid,
        ];



        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $messenger = \Drupal::service('messenger');
        if ($node->get('field_dea')->value - microtime(True) < 0) {
            $messenger->addMessage($this->t('Sorry the auction is closed.'));
            return;
        }
        $user = \Drupal::currentUser()->id();
        $nid = $node->nid->value;

        $database = Database::getConnection();
        $database->delete('azuresimple')
                    ->condition('uid', $user)
                    ->condition('nid', $nid)
                    ->execute();

        $messenger->addMessage($this->t('Your Bid has been Deleted. @currenttime', array('@currenttime' => date('m/d/y H:i:s'))));
    }
}
