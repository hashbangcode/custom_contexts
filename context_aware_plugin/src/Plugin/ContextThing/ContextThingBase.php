<?php

namespace Drupal\context_aware_plugin\Plugin\ContextThing;

use Drupal\Core\Plugin\ContextAwarePluginAssignmentTrait;
use Drupal\Core\Plugin\ContextAwarePluginInterface;
use Drupal\Core\Plugin\ContextAwarePluginTrait;
use Drupal\context_aware_plugin\Plugin\ContextThingInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\PluginBase;

/**
 * Provides a base abstract class for ContextThings.
 */
abstract class ContextThingBase extends PluginBase implements ContextThingInterface, ContextAwarePluginInterface {
  use ContextAwarePluginTrait;
  use ContextAwarePluginAssignmentTrait;

  /**
   * The context repository service.
   *
   * @var \Drupal\Core\Plugin\Context\ContextRepositoryInterface
   */
  protected $contextRepository;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $object = new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
    $object->contextRepository = $container->get('context.repository');
    $object->setDefinedContextValues();
    return $object;
  }

  /**
   * Set values for the defined contexts of this plugin.
   */
  protected function setDefinedContextValues() {
    // Fetch the available contexts.
    $available_contexts = $this->contextRepository->getAvailableContexts();

    // Ensure that the contexts have data by getting corresponding runtime
    // contexts.
    $available_runtime_contexts = $this->contextRepository->getRuntimeContexts(array_keys($available_contexts));
    $plugin_context_definitions = $this->getContextDefinitions();
    foreach ($plugin_context_definitions as $name => $plugin_context_definition) {

      // Identify and fetch the matching runtime context, with the plugin's
      // context definition.
      $matches = $this->contextHandler()
        ->getMatchingContexts($available_runtime_contexts, $plugin_context_definition);
      $matching_context = reset($matches);

      // Set the value to the plugin's context, from runtime context value.
      $this->setContextValue($name, $matching_context->getContextValue());
    }
  }

}
