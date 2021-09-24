<?php
namespace Drupal\koval\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\CssCommand;
//use function GuzzleHttp\Psr7\str;

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

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Your cat's name: "),
      '#placeholder' => $this->t("Enter the cat's name"),
      '#attributes' => [
        'title' => $this->t("Minimum length of the name is 2 characters, and the maximum is 32"),
        'class' => ['custom-class'],
      ],
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t("Your email"),
      "#placeholder" => $this->t('Enter your email'),
      "#required" => TRUE,
      '#attributes' => [
        'title' => $this->t("The name can only contain latin letters, an underscore, or a hyphen"),
        'class' => ['custom-class'],
      ],
      '#ajax' => [
        "callback" => "::validateEmail",
        'event' => 'keyup',
        'progress' => [
          'type' => 'none',
        ],
      ],
      '#suffix' => '<div class="email-validation-message"></div>'
    ];

    $form['cat_image'] = [
      '#type' => "file",
      '#title' => $this->t('Cat image'),
      '#description' => $this->t('Select file with extension jpg, jpeg, png or gif'),
      "#required" => TRUE,
      '#upload_location' => 'public://images/',
      '#upload_validators' => [
        'file_validate_extensions' => ['png gif jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
    ];


    $form['submit'] = [
      '#type' => 'submit',
      '#name' => 'submit',
      '#value' => $this->t("Add cat"),
      '#ajax' => [
        'callback' => '::setMessage',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];

    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div id="result_message"></div>',
    ];

    return $form;
  }


  /**
   * {@inheritDoc}
   */

  public function validateForm(array &$form, FormStateInterface $form_state)
  {}

  /**
   * {@inheritDoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state)
  {}


  /**
   * Ajax submitting.
   */

  public function setMessage(array &$form, FormStateInterface $form_state): object
  {
    $name_pattern ='/[aA-zZ]/';
    $response = new AjaxResponse();
    $cat_name = $form_state->getValue('name');
    if (mb_strlen($cat_name) < 2) {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="cat-message invalid-name-message">' . $this->t('Less than 2 characters in the name')
        )
      );
    } elseif (mb_strlen($cat_name) > 32) {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="cat-message invalid-name-message">' . $this->t('More than 32 characters in the name!')
        )
      );
    } elseif (!preg_match($name_pattern, $cat_name)) {
      $response->addCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="cat-message invalid-name-message">' . $this->t("There are forbidden characters in the cat's name")
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
    elseif (!file_save_upload('cat_image')){
    $response->addCommand(
      new HtmlCommand(
        '#result_message',
        '<div class="cat-message invalid-email-message">' . $this->t('The picture is not loaded!')
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
     }
    \Drupal::messenger()->deleteAll();
    $response->addCommand(new InvokeCommand('.custom-class', 'val', ['']));
    return $response;
  }

  /**
   * Ajax validate Email.
   */

  public function validateEmail(array &$form, FormStateInterface $form_state)
  {
    $ajax_response = new AjaxResponse();
    $email = $form_state->getValue('email');
    for ($j = 0; $j < strlen($email); $j++) {
      if (!preg_match('/[-_@aA-zZ.]/', $email[$j])) {
        $ajax_response->addCommand(
          new HtmlCommand(
            '.email-validation-message',
            '<div class = "invalid-email-message">' . $this->t('The characters you entered are invalid in the email, enter the correct email!') . '</div>'
          )
        );
        $ajax_response->addCommand(
          new CssCommand(
            '.form-email', ['box-shadow' => '2px -2px 59px -9px rgba(217, 26, 8, 0.2) inset',
                                  'border-color' => 'red'],
          )
        );
        break;
      } else {
        $ajax_response->addCommand(
          new HtmlCommand(
            '.email-validation-message',
            ''
          )
        );
        $ajax_response->addCommand(
          new CssCommand(
            '.form-email', ['box-shadow' => 'none',
                          'border-color' => '#006400',]
          )
        );
      }
    }
    return $ajax_response;
  }
}
