<?php

namespace Drupal\koval\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;


/**
 * Returns responses for koval routes.
 */
class CatsController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build():array {
    $form = \Drupal::formBuilder()->getForm('Drupal\koval\Form\FormCats');
    $cats_table = $this->catsTable();
    return [
      '#theme' => 'koval-page',
      '#text' => $this->t('Hello! You can add here a photo of your cat.'),
      '#form' => $form,
      '#cats' => $cats_table['rows'],
      '#header_table' => $cats_table['header_table'],
    ];
  }


  /**
   * Create database table for cats.
   */
  public function catsTable():array {
    $database = \Drupal::database();
    $query = $database->select("koval", 'kov');
    $query->fields('kov', ['id', 'cat_name', 'email', 'cat_image', 'date_created']);
    $result = $query->execute()->fetchAll();
    $rows = [];
    foreach ($result as $value) {
        echo $value->cat_image;
        echo File::load($value->cat_image)->getFileUri('');
        $value->cat_image = [
          '#theme' => 'image_style',
          '#style_name' => 'medium',
          '#uri' => File::load($value->cat_image)->getFileUri(),
          '#attributes' => [
            'class' => 'cat-image',
            'alt' => 'cat',
          ],
        ];

//        echo File::load($value->cat_image)->getFileUri();
      $rows[] = [
        'cat_name' => $value->cat_name,
        'email' => $value->email,
        'cat_image' => ['data' => $value->cat_image],
        'date_created' => date('Y-m-d', $value->date_created),
        'id' => $value->id,
        'edit' => 'Edit',
        'delete' => 'Delete',
      ];
      krsort($rows);
    }

    $header_table = [
      'cat_image' => $this->t('Image'),
      'cat_name' => $this->t('Name'),
      'email' => $this->t('Email'),
      'date_created' => $this->t('Date'),
    ];

    return [
      'rows' => $rows,
      'header_table' => $header_table,
    ];

  }

}
