<?php
namespace Drupal\koval\Controller;
use Drupal\Core\Controller\ControllerBase;
/**
 * Returns responses for koval routes.
 */
class CatsController extends ControllerBase {
  /**
   * Builds the response.
   */
  public function build(): array {
    $build['content'] = [
      '#theme' => 'koval-page',
      '#text' => $this->t('Hello! You can add here a photo of your cat.'),
    ];
    return $build;
  }
}
