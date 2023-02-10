<?php

namespace Drupal\context_aware_plugin\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A controller to demonstrate embedding blocks with context.
 */
class ContextThingController extends ControllerBase {

  /**
   * The context_thing plugin manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $contextThingManager;

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    $object = parent::create($container);

    $object->contextThingManager = $container->get('plugin.manager.context_aware_plugin.context_thing');

    return $object;
  }

  /**
   * Callback for the route custom_contexts_context_thing_page.
   *
   * @return array
   *   The render array.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function testContextThingPage() {
    $userContextThing = $this->contextThingManager->createInstance('user_context_thing');
    $context = $userContextThing->renderContext();
    return [
      '#markup' => '<p>ContextThing output: ' . $context . '</p>',
    ];
  }

}
