<?php

namespace Drupal\custom_contexts\ContextProvider;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextProviderInterface;
use Drupal\Core\Plugin\Context\EntityContext;
use Drupal\Core\Plugin\Context\EntityContextDefinition;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\NodeInterface;

/**
 * Sets the node as a referenced node on the current route node.
 */
class ReferencedNodeContext implements ContextProviderInterface {

  use StringTranslationTrait;

  /**
   * The route match object.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructs a new NodeRouteContext.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match object.
   */
  public function __construct(RouteMatchInterface $route_match) {
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    $result = [];
    $context_definition = EntityContextDefinition::create('node')->setRequired(FALSE);
    $value = NULL;

    // Grab the current route context.
    $route_object = $this->routeMatch->getRouteObject();
    $route_contexts = $route_object->getOption('parameters');

    if (isset($route_contexts['node'])) {
      // We have a node entity in our route parameters.
      $node = $this->routeMatch->getParameter('node');
      if ($node->hasField('field_referenced_article')) {
        // The node contains the field "field_referenced_article".
        $reference = $node->field_referenced_article->referencedEntities();
        if (isset($reference[0]) && $reference[0] instanceof NodeInterface) {
          // A referenced entity exists.
          $value = $reference[0];
        }
      }
    }

    $cacheability = new CacheableMetadata();
    $cacheability->setCacheContexts(['route']);

    $context = new Context($context_definition, $value);
    $context->addCacheableDependency($cacheability);

    $result['node'] = $context;

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    $context = EntityContext::fromEntityTypeId('node', $this->t('Referenced node'));
    return ['node' => $context];
  }

}
