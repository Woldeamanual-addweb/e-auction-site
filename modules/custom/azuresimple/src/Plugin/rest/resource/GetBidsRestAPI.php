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
 * Provides Get Bids Table API for Content Based on URL.
 *
 * @RestResource(
 *   id = "get_bids_rest_resource",
 *   label = @Translation("Bids Table Api"),
 *   uri_paths = {
 *     "canonical" = "/api/bids",
 *     "create" = "api/bids" 

 *   }
 * )
 */

class GetBidsRestAPI extends ResourceBase {

/**
   * Responds to entity Post requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function post($data) {
       if($data){
          try{
        $nid =$data['nid'];
        $database = Database::getConnection();
        $query = $database->select('azuresimple', 'bids')
            ->fields('bids', ['id', 'uid', 'nid', 'bid'])
            ->condition('bids.nid', $nid, '=')
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

        $rows = array();

        foreach ($query as $bid) {

            $rows[] = [
                'id' => $bid->id,
                'uid' => \Drupal\user\Entity\User::load($bid->uid),
                'bid' => $bid->bid,

            ];

            // $rows[] = $row;
        }
      return new ResourceResponse([ "Bids"=>$rows,'error'=>false]);


        }catch(EntityStorageException $e){

       $messenger = ['message'=>"Try Again some error",'error'=>true];
        return new ResourceResponse($messenger);

          }
       }
     
       

    

  
  }

}
