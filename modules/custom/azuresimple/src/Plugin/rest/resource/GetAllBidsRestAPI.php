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
 * Provides Get All Bids Table API for Content Based on URL.
 *
 * @RestResource(
 *   id = "get_all_bids_rest_resource",
 *   label = @Translation("All Bids Table Api"),
 *   uri_paths = {
 *     "canonical" = "/api/allbids",
 *     "create" = "api/allbids" 

 *   }
 * )
 */

class GetAllBidsRestAPI extends ResourceBase {

/**
   * Responds to entity Post requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function post($data) {
          try{
        $database = Database::getConnection();
        $query = $database->select('azuresimple', 'bids')
            ->fields('bids', ['id', 'uid', 'nid', 'bid'])
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

        $rows = array();

        foreach ($query as $bid) {

            $rows[] = [
                'id' => $bid->id,
                'bidder' => \Drupal\user\Entity\User::load($bid->uid),
                'bid' => $bid->bid,
                'node' => \Drupal\node\Entity\Node::load($bid->nid)


            ];

        }
      return new ResourceResponse([ "All_Bids"=>$rows,'error'=>false]);


        }catch(EntityStorageException $e){

       $messenger = ['message'=>"Try Again some error",'error'=>true];
        return new ResourceResponse($messenger);

          }
       
     
       

    

  
  }

}
