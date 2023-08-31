<?php

namespace Drupal\ffw_test\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ffw_test\Entity\Jokes;

/**
 * Class CreateJokeForm.
 *
 * @package Drupal\ffw_test\Form
 */
class CreateJokeForm extends FormBase {

  const FIELDS_TO_SAVE = [
    'categories' => 'Categories',
    'created_at' => 'Created at',
    'icon_url' => 'Icon URL',
    'id' => 'ID',
    'updated_at' => 'Updated at',
    'url' => 'URL',
    'value' => 'Value',
  ];

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'create_joke';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $joke = NULL) {
    $form_state->set('joke', $joke);
    $form['fields_to_save'] = [
      '#type' => 'checkboxes',
      '#tree' => TRUE,
      '#options' => self::FIELDS_TO_SAVE,
    ];


    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save entity',
      '#attributes' => [
        'class' => ['button'],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $joke = $form_state->get('joke');
    $values = $form_state->getValues();
    $entityFields = [];
    foreach ($values['fields_to_save'] as $field) {
      if ($field) {
        $entityFields[] = $field;
      }
    }
    $jokesConfig = \Drupal::config('ffw_test.jokes_settings');
    foreach ($entityFields as $field) {
      $newJoke[$field] = $joke[$jokesConfig->get('$field')];
    }
    $joke = Jokes::create($newJoke);

    $joke->save();
  }

}

