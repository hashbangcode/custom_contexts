<?php

namespace Drupal\context_aware_plugin\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Component\Plugin\FallbackPluginManagerInterface;

/**
 * A plugin manager class for context thing plugins.
 *
 * @package Drupal\context_aware_plugin\Plugin
 */
class ContextThingManager extends DefaultPluginManager implements FallbackPluginManagerInterface {

  /**
   * Constructs a ContextThingManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/ContextThing',
      $namespaces,
      $module_handler,
      'Drupal\context_aware_plugin\Plugin\ContextThingInterface',
      'Drupal\context_aware_plugin\Annotation\ContextThing'
    );
    $this->alterInfo('context_thing_info');
    $this->setCacheBackend($cache_backend, 'context_thing_info_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getFallbackPluginId($plugin_id, array $configuration = []) {
    return 'user_context_thing';
  }

}
