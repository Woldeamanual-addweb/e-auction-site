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
        return [
            \Drupal::formBuilder()->getForm('Drupal\azuresimple\Form\BidForm'),
            '#cache' => ['max-age' => 0],
               ];
    }


}
