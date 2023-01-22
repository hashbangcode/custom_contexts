<?php

namespace Drupal\custom_contexts\ContextProvider;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Plugin\Context\ContextProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Context provider to provide the current IP address of the user.
 */
class IpAddressContext implements ContextProviderInterface {

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * IpAddressContext constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack used to retrieve the current request.
   */
  public function __construct(RequestStack $request_stack) {
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    $value = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $this->requestStack->getCurrentRequest()->getClientIp();

    $context = new Context(new ContextDefinition('string'), $value);
    $context->getContextDefinition()->setLabel('IP Address');

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
