<?php

namespace Drupal\custom_contexts\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Node title' block.
 *
 * @Block(
 *  id = "node_context_block",
 *  label = "Node Context Block",
 *  admin_label = @Translation("Note Context Block"),
 *  context_definitions = {
 *    "node" = @ContextDefinition("entity:node", label = @Translation("Node"))
 *  }
 * )
 */
class NodeContextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\node\Entity\Node $node */
    $node = $this->getContextValue('node');

    if ($node) {
      $build['title'] = [
        '#markup' => $this->t('Title:') . $node->getTitle(),
      ];
    }

    return $build;
  }

}
