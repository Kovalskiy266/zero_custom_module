<?php

namespace Drupal\koval\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class for storing.
 */
class AdminStructureForm extends ConfirmFormBase {

  /**
   * The submitted data needing to be confirmed.
   *
   * @var array
   */
  protected $data = [];

  /**
   * Drupal\Core\Database\ definition.
   *
   * @var \Drupal\Core\Database\
   */
  protected $database;

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    $instanse = parent::create($container);
    $instanse->setMessenger($container->get('messenger'));
    $instanse->database = $container->get('database');
    return $instanse;
  }

  /**
   * {@inheritDoc}
   */
  public function getQuestion() {
    return 'Are you sure?';
  }

  /**
   * {@inheritDoc}
   */
  public function getCancelUrl() {
    return new Url('koval.admin_structure_form');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_admin_cats';
  }

  /**
   * Function for creating module.
   */
  public function catsTable():array {
    $result = $this->database->select('koval', 'kov')
      ->fields('kov', ['id', 'cat_name', 'email', 'cat_image', 'date_created'])
      ->orderBy('id', 'DESC')
      ->execute()
      ->fetchAllAssoc('id', \PDO::FETCH_ASSOC);

    foreach ($result as &$value) {
      $value['cat_image'] = [
        'data' => [
          '#theme' => 'image_style',
          '#style_name' => 'thumbnail',
          '#uri' => File::load($value['cat_image'])->getFileUri(),
          '#attributes' => [
            'class' => 'cat-image',
            'alt' => 'cat',
          ],
        ],
      ];
      $value['date_created'] = date('d-m-Y H:i:s', $value['date_created']);
      $value['delete'] = [
        'data' => [
          '#type' => 'link',
          '#title' => $this->t('Delete'),
          '#url' => Url::fromRoute('koval.admin_structure_delete_form', ['id' => $value['id']]),
          '#attributes' => [
            'class' => ['use-ajax'],
            'data-dialog-type' => ['modal'],
          ],
        ],
      ];
      $value['edit'] = [
        'data' => [
          '#type' => 'link',
          '#title' => $this->t('Edit'),
          '#url' => Url::fromRoute('koval.admin_structure_edit_form', ['id' => $value['id']]),
          '#attributes' => [
            'class' => ['use-ajax'],
            'data-dialog-type' => ['modal'],
          ],
        ],
      ];
      $header = [
        'cat_name' => $this->t('Name'),
        'email' => $this->t('Email'),
        'cat_image' => $this->t('image'),
        'date_created' => $this->t('Date'),
        'delete' => $this->t('Delete'),
        'edit' => $this->t('Edit'),
      ];
    }
    return [
      'table' => $result,
      'header' => $header,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if ($this->data) {
      return parent::buildForm($form, $form_state);
    }
    $table_cat = $this->catsTable();
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $table_cat['header'],
      '#options' => $table_cat['table'],
      '#title' => $this->t('Cats'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Delete сats'),
      '#states' => [
        'enabled' => [
          ':input[name^="table"]' => ['checked' => TRUE],
        ],
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $database = \Drupal::database();
    if (!$this->data) {
      $form_state->setRebuild();
      $this->data = $form_state->getValues();
      return;
    }
    $select_query = $database->select('koval', 'kov')
      ->fields('kov', ['id', 'cat_image'])
      ->condition('id', $this->data['table'], 'IN')
      ->execute();
    foreach ($select_query as $cat) {
      File::load($cat->cat_image)->delete();
    }
    $database->delete('koval')
      ->condition('id', $this->data['table'], 'IN')
      ->execute();
    \Drupal::messenger()->addMessage($this->t('Deleted cats'));

  }

}
