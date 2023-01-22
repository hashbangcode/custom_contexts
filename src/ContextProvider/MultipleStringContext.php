<?php

namespace Drupal\custom_contexts\ContextProvider;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Plugin\Context\ContextProviderInterface;

/**
 * Class to show the setup of multiple contexts from a single provider.
 */
class MultipleStringContext implements ContextProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    $return = [];

    $value = NULL;

    foreach ($unqualified_context_ids as $id) {
      switch ($id) {
        case 'string_value_1':
          $value = 'abcdef';
          break;

        case 'string_value_2':
          $value = 'ghijklmn';
          break;
      }

      $context = new Context(new ContextDefinition('string'), $value);

      $cacheability = new CacheableMetadata();
      $cacheability->setCacheContexts(['route']);
      $context->addCacheableDependency($cacheability);

      $return[$id] = $context;
    }

    return $return;
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    $stringContext1 = new Context(new ContextDefinition('string'));
    $stringContext1->getContextDefinition()->setLabel('String Context 1');

    $stringContext2 = new Context(new ContextDefinition('string'));
    $stringContext2->getContextDefinition()->setLabel('String Context 2');

    return [
      'string_value_1' => $stringContext1,
      'string_value_2' => $stringContext2,
    ];
  }

}
