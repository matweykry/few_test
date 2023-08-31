<?php

namespace Drupal\ffw_test\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the jokes entity edit forms.
 */
class JokesForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New joke %label has been created.', $message_arguments));
        $this->logger('ffw_test')->notice('Created new joke %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The joke %label has been updated.', $message_arguments));
        $this->logger('ffw_test')->notice('Updated joke %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.jokes.canonical', ['jokes' => $entity->id()]);

    return $result;
  }

}
