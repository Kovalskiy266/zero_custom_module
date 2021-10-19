<?php

namespace Drupal\koval\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class DeleteCatsForm for delete cats.
 *
 * @package Drupal\koval\Form
 */
class AdminStructureDeleteForm extends DeleteCatsForm {

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('koval.admin_structure_form');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $form_state->setRedirect('koval.admin_structure_form');
  }

}
