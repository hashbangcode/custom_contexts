<?php

namespace Drupal\context_aware_plugin\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a context thing plugin.
 *
 * Plugin Namespace: Plugin\ContextThing.
 *
 * @see plugin_api
 *
 * @Annotation
 */
class ContextThing extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the context thing plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $name;

}
