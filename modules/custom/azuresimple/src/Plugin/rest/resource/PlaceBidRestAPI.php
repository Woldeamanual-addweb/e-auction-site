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
 * Provides Placing Bid API for Content Based on URL.
 *
 * @RestResource(
 *   id = "get_bid_rest_resource",
 *   label = @Translation("Place Bid Api"),
 *   uri_paths = {
 *     "canonical" = "/api/placeBid",
 *     "create" = "api/placeBid" 

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
  public function post($data) {

        if($data){
         try{
        $nid=$data['nid'];
        $amount=$data['amount'];
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

        db_insert('azuresimple')->fields(array(
            'bid' => $amount,
            'nid' => $nid,
            'uid' => $user->id(),
            'created' => time(),
        ))->execute();
           $messenger = ['message'=>"Your bid placed successfully",'error'=>false];
           return new ResourceResponse($messenger);



           }catch(EntityStorageException $e){
              $messenger = ['message'=>"Try Again some error",'error'=>true];
              return new ResourceResponse($messenger);

           }
        }
       


    
  
  }

}
