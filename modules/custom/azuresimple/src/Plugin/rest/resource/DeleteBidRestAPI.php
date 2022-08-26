<?php

namespace Drupal\azuresimple\Plugin\rest\resource;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Url;
use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\ResourceResponse;

/**
 * Provides Delete Bid API for Content Based on URL.
 *
 * @RestResource(
 *   id = "delete_bid_rest_resource",
 *   label = @Translation("Delete Bid Api"),
 *   uri_paths = {
 *     "canonical" = "/api/bid_delete",
 *     "create" = "api/bid_delete" 
 *   }
 * )
 */

class DeleteBidRestAPI extends ResourceBase {

/**
   * Responds to entity POST requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function post($data) {
        // $node = \Drupal\node\Entity\Node::load(\Drupal::request()->query->has('nid'));
        // if ($node->get('field_dea')->value - microtime(True) < 0) {
        //     $messenger->addMessage($this->t('Sorry the auction is closed.'));
        //       $response = ['message' => 'Hello, this is a rest service'];
        //       return new ModifiedResourceResponse($response);
        // }

        $user = \Drupal::currentUser()->id();
        $nid = $data['nid'];
      try{
        $database = Database::getConnection();
        $database->delete('azuresimple')
                    ->condition('uid', $user)
                    ->condition('nid', $nid)
                    ->execute();

         $messenger = ['message'=>"Bid Deleted Successfully"];
                 return new ResourceResponse($messenger);

   
      }catch(EntityStorageException $e){
              $messenger = ['message'=>"Try Again some error"];
               return new ResourceResponse($messenger);


      }
       

    

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
