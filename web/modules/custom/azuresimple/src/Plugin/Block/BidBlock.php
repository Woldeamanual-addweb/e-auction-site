<?php

/**
 * @file
 * Contains \Drupal\azursimple\Plugin\Block\BidBlock
 */

namespace Drupal\azuresimple\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides Bid Block
 * @Block(
 * id = "Bid Block",
 * admin_label = @Translation("Bid Block"),
 * )
 */

class BidBlock extends BlockBase
{
    /**
     * {@inheritDoc}
     */

    public function build()
    {
        return \Drupal::formBuilder()->getForm('Drupal\azuresimple\Form\BidForm');
    }

    // public function blockAccess(AccountInterface $account)
    // {
    //     /**
    //      * @var \Drupal\node\Entity\Node $node 
    //      */
    //     $node = \Drupal::routeMatch()->getParameter('node');
    //     $nid = $node->nid->value;
    //     if (is_numeric($nid)) {
    //         return AccessResult::allowedIfHasPermission($account, 'view');
    //     }
    //     return 
    // }
}
