<?php

namespace Drupal\koval\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for koval routes.
 */
class AdminController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build():array {
    $admin_form = \Drupal::formBuilder()->getForm('Drupal\koval\Form\AdminStructureForm');
    return [
      '#theme' => 'admin-structure-form',
      '#admin_form' => $admin_form,
    ];
  }

}
