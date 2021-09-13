<?php
namespace Drupal\koval\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for submitting cats.
 */
class FormCats extends FormBase
{

  /**
   * {@inheritDoc}
   */
  public function getFormId(): string
  {
    return 'koval_formCats';
  }

  /**
   * {@inheritDoc}
   */

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Your cat's name: "),
      '#placeholder' => $this->t("Enter the cat's name"),
      '#attributes' => array(
        'title' => t("Minimum length of the name is 2 characters, and the maximum is 32"),
      )
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("Add cat"),
    ];
    return $form;
  }

  /**
   * {@inheritDoc}
   */

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if(strlen($form_state->getValue('name')) < 2) {
        $form_state->setErrorByName('name', $this->t('Data is invalid, less than two characters, please try again'));
    }
    if(strlen($form_state->getValue('name')) > 32) {
      $form_state->setErrorByName('name', $this->t('Data is invalid and contains more than 32 characters. Please try again'));
    }

  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->messenger()->addStatus($this->t('Your cat is added'));
  }

}
