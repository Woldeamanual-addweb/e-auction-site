<?php

namespace Drupal\azuresimple\Plugin\rest\resource;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;
use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;

/**
 * Provides Placing Bid API for Content Based on URL.
 *
 * @RestResource(
 *   id = "get_bid_rest_resource",
 *   label = @Translation("Place Bid Api"),
 *   uri_paths = {
 *     "canonical" = "/api/placeBid"
 *   }
 * )
 */

class PlaceBidRestAPI extends ResourceBase {

/**
   * Responds to entity Post requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function post() {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $messenger = \Drupal::service('messenger');
        if ($node->get('field_dea')->value - microtime(True) < 0) {
            $messenger->addMessage($this->t('Sorry the auction is closed.'));
            return;
        }
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

        // db_insert('azuresimple')->fields(array(
        //     'bid' => 10000,
        //     'nid' => 1,
        //     'uid' => $user->id(),
        //     'created' => time(),
        // ))->execute();


        $messenger->addMessage($this->t('Your Bid has been placed. @currenttime', array('@currenttime' => date('m/d/y H:i:s'))));
    

    // if (\Drupal::request()->query->has('url') ) {
      
    //   $url = \Drupal::request()->query->get('url');

    //   if (!empty($url)) {
        
    //     $query = \Drupal::entityQuery('node')
    //       ->condition('field_unique_url', $url);
        
    //     $nodes = $query->execute();
        
    //     $node_id = array_values($nodes);

        
    //     if (!empty($node_id)) {
        
    //       $data = Node::load($node_id[0]);
    //       return new ModifiedResourceResponse($data);

    //   		}
    //   	}
 	// }
  
  }

}
