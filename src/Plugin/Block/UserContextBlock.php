<?php

namespace Drupal\custom_contexts\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'User' block.
 *
 * @Block(
 *  id = "user_context_block",
 *  label = "User Context Block",
 *  admin_label = @Translation("User Context Block"),
 *  context_definitions = {
 *    "user" = @ContextDefinition("entity:user", label = @Translation("User"))
 *  }
 * )
 */
class UserContextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\user\Entity\User $user */
    $user = $this->getContextValue('user');

    if ($user) {
      $build['user'] = [
        '#markup' => $this->t('Username:') . $user->getAccountName(),
      ];

    }
    return $build;
  }

}
