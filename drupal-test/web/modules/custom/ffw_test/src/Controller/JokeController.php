<?php

use Drupal\Core\Controller\ControllerBase;
use Drupal\hc_client_service_api\ApiRequestSenderService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Get all applications per user.
 */
class JokeController extends ControllerBase {

  private $apiRequestService;

  public function __construct(ApiRequestSenderService $apiRequestService) {
    $this->apiRequestService = $apiRequestService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('ffw_test.apiRequestSenderService'),
    );
  }

  /**
   * Retrieve and create new Joke.
   */
  private function getJoke() {

    //Retrieve new Joke.
    $joke = $this->apiRequestService->createRequest('GET', \Drupal::config('ffw_test.admin_settings')
      ->get('api_url'));
    $createJokeForm = \Drupal::formBuilder()
      ->getForm(
        'Drupal\ffw_test\Form\CreateJokeForm',
        $joke);
    $build['#theme'] = 'create_joke';
    $build['#joke'] = [
      'categories' => [
        'title' => $this->t('Categories'),
        'value' => $joke['categories'],
      ],
      'id' => [
        'title' => $this->t('ID'),
        'value' => $joke['id'],
      ],
      'url' => [
        'title' => $this->t('URL'),
        'value' => $joke['url'],
      ],
      'icon_url' => [
        'title' => $this->t('Icon URL'),
        'value' => $joke['icon_url'],
      ],
      'value' => [
        'title' => $this->t('Value'),
        'value' => $joke['value'],
      ],
      'created_at' => [
        'title' => $this->t('Created at'),
        'value' => $joke['created_at'],
      ],
      'updated_at' => [
        'title' => $this->t('Updated at'),
        'value' => $joke['updated_at'],
      ],

    ];
    $build['#createJokeForm'] = $createJokeForm;
    return $build;
  }

}
