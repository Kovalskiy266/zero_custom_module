<?php

namespace Drupal\koval\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;

/**
 * Class DeleteCatsForm for delete cats.
 *
 * @package Drupal\koval\Form
 */
class DeleteCatsForm extends ConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return $this->t('delete_form_cat');
  }

  /**
   * {@inheritdoc}
   */
  public $id;

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Delete cats');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('koval.cats');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('Do this if you are sure you want it!');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete it!');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return $this->t('Cancel');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $query = \Drupal::database();
    $query->delete('koval')
      ->condition('id', $this->id)
      ->execute();
    $this->messenger()->addStatus(("The cat was deleted"));
    $form_state->setRedirect('koval.cats');
  }

}
