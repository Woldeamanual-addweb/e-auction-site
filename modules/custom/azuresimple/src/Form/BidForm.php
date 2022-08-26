<?php

/**
 * @file
 * Contains \Drupal\azuresimple\Form\BidForm
 */

namespace Drupal\azuresimple\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides Bid Form.
 */

class BidForm extends FormBase
{
    /**
     * (@inheritDoc)
     */
    public function getFormId()
    {
        return 'bid_form';
    }


    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $database = Database::getConnection();

        $form = [];
        if ($node->get('field_dea')->value - microtime(True) < 0) {
            $messenger = \Drupal::service('messenger');
            $messenger->addMessage($this->t('Auction is Over '));
            $query = $database->select('azuresimple', 'bids')
            ->fields('bids', ['id', 'uid', 'nid', 'bid'])
            ->condition('bids.nid', $nid, '=')
            ->orderBy('bids.bid', 'DESC')
            ->range(0, 1)
            ->execute()->fetchAll(\PDO::FETCH_OBJ);
            foreach ($query as $bid) {

            $amount = $bid->bid;
            $user = $bid->uid;


        
        }
            if(empty($amount)){
                 $messenger->addMessage($this->t('There is no Winner.'));
            return $form;
            }
            
            $messenger->addMessage($this->t('The winner is @winner.',array('@winner'=>$amount)));
            return $form;
        }
        if(!\Drupal::currentUser()->isAuthenticated()){
            return $form;
        }
        $form['amount'] = [
            '#type' => 'number',
            '#title' => $this->t('Place Bid'),
            '#size' => 25,
            '#required' => TRUE,



        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Place Bid'),
            '#button_type' => 'secondary'
        ];

        $form['nid'] = [
            '#type' => 'hidden',
            '#value' => $nid,
        ];

        $messenger = \Drupal::service('messenger');
        $messenger->addMessage($this->t('Remaining Time @currenttime', array('@currenttime' => $this->seconds2human($node->get('field_dea')->value - microtime(True)))));



        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $value = $form_state->getValue('amount');
        $node = \Drupal::routeMatch()->getParameter('node');
        if ($node) {

            $reserve = $node->get('field_reserve')->value;
            if ($value <= $reserve) {
                $form_state->setErrorByName('bid', t("Bid can't be below  $reserve ", array('%bid' => $value)));
            }
        }
    }

    public function seconds2human($ss)
    {
        $s = $ss % 60;
        $m = floor(($ss % 3600) / 60);
        $h = floor(($ss % 86400) / 3600);
        $d = floor(($ss % 2592000) / 86400);
        $M = floor($ss / 2592000);

        return "$M months, $d days, $h hours, $m minutes, $s seconds";
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $messenger = \Drupal::service('messenger');
        if ($node->get('field_dea')->value - microtime(True) < 0) {
            $messenger->addMessage($this->t('Sorry the auction is closed.'));
        
            return;
        }
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

        db_insert('azuresimple')->fields(array(
            'bid' => $form_state->getValue('amount'),
            'nid' => $form_state->getValue('nid'),
            'uid' => $user->id(),
            'created' => time(),
        ))->execute();


        $messenger->addMessage($this->t('Your Bid has been placed. @currenttime', array('@currenttime' => date('m/d/y H:i:s'))));
    }
}
