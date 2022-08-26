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
 * Provides Delete Bid API for Content Based on URL.
 *
 * @RestResource(
 *   id = "delete_bid_rest_resource",
 *   label = @Translation("Delete Bid Api"),
 *   uri_paths = {
 *     "canonical" = "/api/bidDelete/{nid}"
 *   }
 * )
 */

class DeleteBidRestAPI extends ResourceBase {

/**
   * Responds to entity GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function get() {
        $messenger = \Drupal::service('messenger');
       $messenger->addMessage($this->t('Your Bid has been Deleted. @currenttime', array('@currenttime' => date('m/d/y H:i:s'))));
        return new ModifiedResourceResponse($messenger);
        // $node = $node = \Drupal\node\Entity\Node::load(\Drupal::request()->query->has('nid'));
        // if ($node->get('field_dea')->value - microtime(True) < 0) {
        //     $messenger->addMessage($this->t('Sorry the auction is closed.'));
        //       $response = ['message' => 'Hello, this is a rest service'];
        //       return new ModifiedResourceResponse($response);
        // }

        // $user = \Drupal::currentUser()->id();
        // $nid = $node->nid->value;

        // $database = Database::getConnection();
        // $database->delete('azuresimple')
        //             ->condition('uid', $user)
        //             ->condition('nid', $nid)
        //             ->execute();

        // $messenger->addMessage($this->t('Your Bid has been Deleted. @currenttime', array('@currenttime' => date('m/d/y H:i:s'))));
   

    

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
