<?php
namespace Drupal\koval\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;


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
        'class' => ['custom-class'],
      ),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("Add cat"),
      '#ajax' => [
        'callback' => '::setMessage',
        'progress' => array(
          'type' => 'none',
        ),
      ],
    ];

    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>'
    ];
    return $form;
  }

  /**
   * {@inheritDoc}
   */

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if(mb_strlen($form_state->getValue('name')) < 2) {
      $this->t('Data is invalid and contains more than 32 characters. Please try again');
    }
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
  }

  /**
   * Ajax submitting.
   */

  public function setMessage(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if(mb_strlen($form_state->getValue('name')) < 2) {
      $response->addCommand(
        new HtmlCommand(
          '.result_message',
          '<div class="invalid_message">' . $this->t('Data is invalid, less than two characters, please try again') . '</div>'),
      );
    }
    elseif(mb_strlen($form_state->getValue('name')) > 32){
    $response->addCommand(
      new HtmlCommand(
        '.result_message',
        '<div class="invalid_message">' . $this->t('Data is invalid and contains more than 32 characters. Please try again') . '</div>')
    );
    }
    else
      {
        $response->addCommand(
          new HtmlCommand(
            '.result_message',
            '<div class="valid_message">' . t('Your cat @result is sent', ['@result' => ($form_state->getValue('name'))]) . '</div>'),
        );
      }
      $response->addCommand(new InvokeCommand('.custom-class', 'val', ['']));
      return $response;
  }
}
