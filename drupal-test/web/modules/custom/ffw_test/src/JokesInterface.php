<?php

namespace Drupal\ffw_test;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a jokes entity type.
 */
interface JokesInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
