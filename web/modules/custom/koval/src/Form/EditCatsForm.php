<?php

namespace Drupal\koval\Form;

use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Form for edditing cats.
 */
class EditCatsForm extends FormCats {

  /**
   * {@inheritDoc}
   */
  public function getFormId(): string {
    return 'koval_edit_cat_form';
  }

  /**
   * Cat to edit if any.
   *
   * @var object
   */
  protected $cat;

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, int $id = NULL): array {
    $database = \Drupal::database();
    $result = $database->select('koval', 'kov')
      ->fields('kov', ['id', 'cat_name', 'email', 'cat_image', 'date_created'])
      ->condition('id', $id)
      ->execute()
      ->fetch();
    $this->cat = $result;
    $form = parent::buildForm($form, $form_state);
    $form['name']['#default_value'] = $result->cat_name;
    $form['email']['#default_value'] = $result->email;
    $form['cat_image']['#default_value'][] = $result->cat_image;
    $form['submit']['#value'] = $this->t('Edit cat');
    return $form;
  }

  /**
   * Submit edit version of the cat.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $database = \Drupal::database();
    $cat_name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $cat_image = $form_state->getValue('cat_image')[0];
    $database
      ->update('koval')
      ->condition('id', $this->cat->id)
      ->fields(
        [
          'cat_name' => $cat_name,
          'email' => $email,
          'cat_image' => $cat_image,
        ],
      )
      ->execute();
    if ($cat_image != $this->cat->cat_image) {
      File::load($this->cat->cat_image)->delete();
    }
  }

  /**
   * Ajax submitting.
   */
  public function setMessage(array &$form, FormStateInterface $form_state): object {
    $response = parent::setMessage($form, $form_state);
    if (!$form_state->hasAnyErrors()) {
      $response->addCommand(new CloseModalDialogCommand());
    }
    return $response;
  }

}
