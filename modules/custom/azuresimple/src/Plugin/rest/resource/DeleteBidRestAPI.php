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
       
  
  }

}
