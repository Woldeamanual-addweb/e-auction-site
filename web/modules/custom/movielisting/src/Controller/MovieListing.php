<?php

/**
 *  @file  
 *  Contains \Drupal\azuresimple\Controller\FirstController.
 */

namespace Drupal\movielisting\Controller;

use Drupal\Core\Controller\ControllerBase;

class MovieListing extends ControllerBase
{

    public function view()
    {
        $this->listMovies();
        $content = [];
        $content['name'] = 'Ben is here';
        return [
            '#theme' => 'movielisting',
            '#content' => $content
        ];
    }

    public function listMovies()
    {
        /** @var MovieAPIConnector $movielisting_api_connector_service */
        $movie_api_connector_service = \Drupal::service('movielisting.api_connector');
        $movie_list = $movie_api_connector_service->discoverMovies();

        if (!empty($movie_list->results)) {
            echo "ffff";
            return $movie_list->results;
        }
        return ['no data'];
    }
}
