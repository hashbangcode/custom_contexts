<?php

namespace Drupal\custom_contexts\ContextProvider;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Plugin\Context\ContextProviderInterface;

/**
 * Context provider to generate a random IP address.
 */
class RandomIpAddressContext implements ContextProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    $value = rand(0, 256) . '.' . rand(0, 256) . '.' . rand(0, 256) . '.' . rand(0, 256);

    $context = new Context(new ContextDefinition('string'), $value);
    $context->getContextDefinition()->setLabel('Random IP');

    $cacheability = new CacheableMetadata();
    $cacheability->setCacheContexts(['ip']);
    $context->addCacheableDependency($cacheability);

    return [
      'ip' => $context,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    return $this->getRuntimeContexts([]);
  }

}
