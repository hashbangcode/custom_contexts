<?php

namespace Drupal\custom_contexts\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'IP Address' block.
 *
 * @Block(
 *  id = "ip_context_block",
 *  label = "IP Address Context Block",
 *  admin_label = @Translation("IP Address Context Block"),
 *  context_definitions = {
 *    "ip_address" = @ContextDefinition("string", label = @Translation("IP Address"))
 *  }
 * )
 */
class IpContextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $ip = $this->getContextValue('ip_address');

    $build = [];

    if ($ip) {
      $build['value'] = [
        '#markup' => $this->t('IP Address:') . $ip,
      ];
    }

    return $build;
  }

}
