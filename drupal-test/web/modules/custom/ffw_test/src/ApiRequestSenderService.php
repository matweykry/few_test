<?php

namespace Drupal\hc_client_service_api;


use Drupal\Component\Serialization\Json;
use Drupal\Core\Logger\LoggerChannelFactory;
use GuzzleHttp\ClientInterface;

/**
 * Class ApiRequestSenderService
 *
 * @package Drupal\ffw_test\Services
 */
class ApiRequestSenderService {

  /**
   * A http client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $client;

  /**
   * Logger Factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $loggerFactory;

  /**
   * CustomService constructor.
   *
   * @param ClientInterface $client
   * @param LoggerChannelFactory $loggerFactory
   */
  public function __construct(ClientInterface $client, LoggerChannelFactory $loggerFactory) {
    $this->client = $client;
    $this->loggerFactory = $loggerFactory->get('hc_client_service_api');
  }

  /**
   * @return \Drupal\Component\Render\MarkupInterface|string
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function createRequest($method, $uri, $body = [], $query = [], $headers = [], $timeout = 15) {
    $moduleLogger = \Drupal::logger('ffw_test');
    $moduleLogger->warning('<pre><code>Request Body:' . json_encode($body) . '</code></pre>');
    $moduleLogger->warning('<pre><code>Request Query:' . json_encode(http_build_query($query)) . '</code></pre>');
    $headers['Authorization'] = 'Basic ' . base64_encode(getenv('CS_API_USERNAME') . ':' . getenv('CS_API_PASSWORD'));
    $options = [
      'body' => json_encode($body),
      'query' => http_build_query($query, "", null, PHP_QUERY_RFC3986),
      'timeout' => $timeout,
      'headers' => $headers,
    ];

    try {
      $response = $this->client->request(
        $method,
        $uri,
        $options
      );
      $code = $response->getStatusCode();
      $moduleLogger->warning('<pre><code>Response Body: ' . print_r(Json::decode($response->getBody()), TRUE) . '</code></pre>');
      if ($code == 200) {
        return Json::decode($response->getBody());
      }
    }
    catch (\Exception $error) {
      $logger = \Drupal::logger('HTTP Client error');
      $logger->error($error->getMessage());
    }

    return NULL;
  }

}
