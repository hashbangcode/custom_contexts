<?php

namespace Drupal\custom_contexts\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Plugin\ContextAwarePluginInterface;
use Drupal\Core\Plugin\Context\ContextRepositoryInterface;
use Drupal\Core\Plugin\Context\ContextHandlerInterface;

/**
 * A controller to demonstrate embedding blocks with context.
 */
class TestController extends ControllerBase {

  /**
   * The plugin manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected PluginManagerInterface $pluginManagerBlock;

  /**
   * The context repository service.
   *
   * @var \Drupal\Core\Plugin\Context\ContextRepositoryInterface
   */
  protected ContextRepositoryInterface $contextRepository;

  /**
   * The plugin context handler.
   *
   * @var \Drupal\Core\Plugin\Context\ContextHandlerInterface
   */
  protected ContextHandlerInterface $contextHandler;

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    $object = parent::create($container);

    $object->pluginManagerBlock = $container->get('plugin.manager.block');
    $object->contextRepository = $container->get('context.repository');
    $object->contextHandler = $container->get('context.handler');

    return $object;
  }

  /**
   * Callback for custom_contexts_block_page.
   *
   * @return array
   *   The page render array.
   *
   * @throws \Drupal\Component\Plugin\Exception\ContextException
   * @throws \Drupal\Component\Plugin\Exception\MissingValueContextException
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function blockPage() {
    // Create the block configuration.
    $config = [
      'context_mapping' => [
        'user' => '@user.current_user_context:current_user',
      ],
    ];
    // Create the block object.
    $pluginBlock = $this->pluginManagerBlock->createInstance('user_context_block', $config);

    if ($pluginBlock instanceof ContextAwarePluginInterface) {
      // Inject the configured context into the block.
      $contexts = $this->contextRepository->getRuntimeContexts($pluginBlock->getContextMapping());
      $this->contextHandler->applyContextMapping($pluginBlock, $contexts);
    }

    // Some blocks might implement access check.
    $accessResult = $pluginBlock->access($this->currentUser);

    // Return empty render array if user doesn't have access.
    if ((is_object($accessResult) && $accessResult->isForbidden()) || (is_bool($accessResult) && !$accessResult)) {
      return [];
    }

    // Build and return render array.
    return $pluginBlock->build();
  }

}
