<?php

namespace Drupal\context_aware_plugin\Plugin\ContextThing;

/**
 * Provides a user context thing plugin.
 *
 * @ContextThing(
 *   id = "user_context_thing",
 *   name = @Translation("User"),
 *   context_definitions = {
 *     "user" = @ContextDefinition("entity:user", label = @Translation("User"))
 *   }
 * )
 */
class UserContextThing extends ContextThingBase {

  /**
   * {@inheritdoc}
   */
  public function renderContext():string {
    $user = $this->getContextValue('user');
    return $user->label();
  }

}
