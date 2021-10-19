<?php

namespace Drupal\koval\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class DeleteCatsForm for edit cats.
 *
 * @package Drupal\koval\Form
 */
class AdminStructureEditForm extends EditCatsForm {

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

  /**
   * {@inheritdoc}
   */
  public function setMessage(array &$form, FormStateInterface $form_state): object {
    $response = new AjaxResponse();
    $cat_name = $form_state->getValue('name');
    if (!preg_match('/^[aA-zZ]{2,32}$/', $cat_name)) {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="invalid-name-message">' . $this->t("The cat's name must contain between 2 and 32 Latin characters")
        )
      );
    }
    elseif (!preg_match('/^[-_aA-zZ]{2,30}@([a-z]{2,10})\.[a-z]{2,10}$/', $form_state->getValue('email'))) {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="cat-message invalid-email-message">' . $this->t('Your email is not supported')
        )
      );
    }
    elseif ($form_state->hasAnyErrors()) {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="cat-message invalid-email-message">' . $this->t('Error filling out the form, check that all fields are filled!')
        )
      );
    }
    else {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="cat-message send-message">' .
          $this->t('Thanks! Your cat by name @result has been sent',
            ['@result' => ($form_state->getValue('name'))])
        )
      );
      $response->addCommand(new RedirectCommand('\admin\structure\cats'));
    }
    \Drupal::messenger()->deleteAll();
    $response->addCommand(new InvokeCommand('.custom-class', 'val', ['']));

    return $response;

  }

}
