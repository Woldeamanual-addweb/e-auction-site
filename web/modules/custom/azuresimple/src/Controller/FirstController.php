<?php

/**
 *  @file  
 *  Contains \Drupal\azuresimple\Controller\FirstController.
 */

namespace Drupal\azuresimple\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FirstController extends ControllerBase
{
    public function content()
    {
        return [
            '#markup' => $this->t('Welcome..'),
        ];
    }
}
