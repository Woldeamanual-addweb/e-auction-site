<?php

/**
 * @file
 * Contains \Drupal\azuresimple\Plugin\Block\BestBidBlock
 */

namespace Drupal\azuresimple\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;



/**
 * Provides Best Bid Block
 * @Block(
 * id = "Best Bid Block",
 * admin_label = @Translation("Best Bid Block"),
 * )
 */

class BestBidBlock extends BlockBase
{
    /**
     * {@inheritDoc}
     */

    public function build()
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;


        $database = Database::getConnection();
        $query = $database->select('azuresimple', 'bids')
            ->fields('bids', ['id', 'uid', 'nid', 'bid'])
            ->condition('bids.nid', $nid, '=')
            ->orderBy('bids.bid', 'DESC')
            ->range(0, 1)
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

        $rows = array();

        foreach ($query as $bid) {

            $rows[] = [
                'bid' => $bid->bid,
            

            ];

        }
        $headers = array(

            t('Best Bid'),

        );




        $build['table'] = array(
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $rows,
            '#cache' => ['max-age' => 0],
            '#empty' => t('No Bids Available!'),
        );

        return $build;
    }
}
