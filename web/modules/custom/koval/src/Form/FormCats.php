<?php
//namespace Drupal\koval\Form;
//use Drupal\Core\Form\FormBase;
//use Drupal\Core\Form\FormStateInterface;
//
///**
// * Implements an example form.
// */
//
//class CatsForm extends FormBase {
//  /**
//   * {@inheritDoc}
//   */
//  public function getFormId() : string
//  {
//    return 'koval_form';
//  }
//  /**
//   * {@inheritDoc}
//   */
//  public function buildForm(array $form, FormStateInterface $form_state):array
//  {
//
//    $form['#theme'] = 'koval-page';
//    $form['name'] = [
//      "#type" =>'textfield',
//      "#title" =>$this->t('Your cat’s name:')
//    ];
//
//    $form['actions']['#type'] = 'actions';
//    $form['actions']['submit'] = [
//      "#type" =>'submit',
//      '#value' => $this->t('Add Cat'),
//    ];
//    return $form;
//  }
////  public function submitForm(array &$form, FormStateInterface $form_state) {
////    $this->messenger()->addStatus($this->t('Your cat name is @text', ['@text' => $form_state->getValue('name')]));
////  }
//
//  /**
//   * {@inheritDoc}
//   */
//  public function submitForm(array &$form, FormStateInterface $form_state) {
//    \Drupal::messenger()->addStatus(t('Succes'));
//  }
//}


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
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->messenger()->addStatus($this->t('Your cat is added'));
  }

}
