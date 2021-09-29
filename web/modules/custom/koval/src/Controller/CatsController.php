<?php
namespace Drupal\koval\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
/**
 * Returns responses for koval routes.
 */
class CatsController extends ControllerBase
{

  /**
   * Builds the response.
   */

  public function build(): array
  {
    $form = \Drupal::formBuilder()->getForm('Drupal\koval\Form\FormCats');
    $cats[] = $this->CatsTable();
    $build['content'] = [
      '#theme' => 'koval-page',
      '#text' => $this->t('Hello! You can add here a photo of your cat.'),
      '#form' => $form,
      '#cats' => $cats,
    ];
    return $build;
  }

  /**
   * Create database table for cats.
   */

  public function CatsTable():array {
    $database = \Drupal::database();
    $query = $database->select("koval", 'kov');
    $query->fields('kov', ['cat_name', 'email', 'cat_image', 'date_created']);
    $result = $query->execute()->fetchAll();
    $cats_table = [];
    foreach ($result as $value) {
      $value->cat_image = [
        '#theme' => 'image_style',
        '#style_name' => 'medium',
        '#uri' => File::load($value->cat_image)->getFileUri(),
        '#attributes' => [
          'class' => 'cat-image',
          'alt' => 'cat',
          ],
      ];
      $rows[] = [
        'cat_name' => $value->cat_name,
        'email' => $value->email,
        'cat_image' => ['data' => $value->cat_image],
        'date_created' => date('Y-m-d', $value->date_created),
      ];
      $header = [
        'cat_name' => $this->t('Cat Name'),
        'email' => $this->t('Email'),
        'cat_image' => $this->t('Cat Image'),
        'date_created' => $this->t('Date'),
      ];

      $build['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        ];
    }
     return $build;
  }
}


