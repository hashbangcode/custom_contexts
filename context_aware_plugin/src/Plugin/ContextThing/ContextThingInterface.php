<?php

namespace Drupal\context_aware_plugin\Plugin\ContextThing;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Defines the interface for context thing plugins.
 *
 * @package Drupal\context_aware_plugin\Plugin
 */
interface ContextThingInterface extends PluginInspectionInterface, ContainerFactoryPluginInterface {

  /**
   * Render the context.
   *
   * @return string
   *   The rendered context.
   */
  public function renderContext():string;

}
