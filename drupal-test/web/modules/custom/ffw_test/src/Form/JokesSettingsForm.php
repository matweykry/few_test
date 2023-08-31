<?php

namespace Drupal\ffw_test\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for a jokes entity type.
 */
class JokesSettingsForm extends ConfigFormBase {

  const API_FIELDS = [
    'categories' => 'categories',
    'created_at' => 'created_at',
    'icon_url' => 'icon_url',
    'id' => 'id',
    'updated_at' => 'updated_at',
    'url' => 'url',
    'value' => 'value',
    ];

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'jokes_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ffw_test.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ffw_test.admin_settings');

    $form['settings'] = [
      '#markup' => $this->t('Settings form for a jokes entity type.'),
    ];

    $form['api_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API URL'),
      '#description' => $this->t('Set up API url where the requests will be sent.'),
      '#default_value' => $config->get('api_url'),
    ];

    $form['api_mapping'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Set up mapping for entity field with API values.'),
    ];
    $form['api_mapping']['value'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('Value'),
      '#default_value' => $config->get('value'),
    ];
    $form['api_mapping']['id'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('ID'),
      '#default_value' => $config->get('id'),
    ];
    $form['api_mapping']['created'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('Created'),
      '#default_value' => $config->get('created'),
    ];
    $form['api_mapping']['changed'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('Changed'),
      '#default_value' => $config->get('changed'),
    ];
    $form['api_mapping']['icon_url'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('Icon URL'),
      '#default_value' => $config->get('icon_url'),
    ];
    $form['api_mapping']['url'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('URL'),
      '#default_value' => $config->get('url'),
    ];
    $form['api_mapping']['categories'] = [
      '#type' => 'select',
      '#options' => self::API_FIELDS,
      '#title' => $this->t('Categories'),
      '#default_value' => $config->get('categories'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    foreach ($values as $value) {
      $this->config('ffw_test.admin_settings')
        ->set($value, $form_state->getValue($value))
        ->save();
    }

    parent::submitForm($form, $form_state);
    $this->messenger()->addStatus($this->t('The configuration has been updated.'));
  }

}
