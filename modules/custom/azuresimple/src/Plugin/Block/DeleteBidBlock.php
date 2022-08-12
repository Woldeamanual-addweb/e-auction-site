<?php

/**
 * @file
 * Contains \Drupal\azuresimple\Plugin\Block\DeleteBidBlock
 */

namespace Drupal\azuresimple\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;



/**
 * Provides Delete Bid Block
 * @Block(
 * id = "Delete Bid Block",
 * admin_label = @Translation("Delete Bid Block"),
 * )
 */

class DeleteBidBlock extends BlockBase
{
    /**
     * {@inheritDoc}
     */

       public function build()
    {
        return \Drupal::formBuilder()->getForm('Drupal\azuresimple\Form\DeleteForm');
    }

}
