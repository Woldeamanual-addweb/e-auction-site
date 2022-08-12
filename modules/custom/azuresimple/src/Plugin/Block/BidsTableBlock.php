<?php

/**
 * @file
 * Contains \Drupal\azursimple\Plugin\Block\BidsTableBlock
 */

namespace Drupal\azuresimple\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Database\Database;




/**
 * Provides Bids Table Block
 * @Block(
 * id = "BidsTable Block",
 * admin_label = @Translation("BidsTable Block"),
 * )
 */

class BidsTableBlock extends BlockBase
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
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

        $rows = array();

        foreach ($query as $bid) {

            $rows[] = [
                'id' => $bid->id,
                'uid' => $bid->uid,
                'bid' => $bid->bid,

            ];

            // $rows[] = $row;
        }
        $headers = array(

            t('Id'),
            t('User'),
            t('Amount'),

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
