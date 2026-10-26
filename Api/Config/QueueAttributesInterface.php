<?php

namespace Rcason\Mq\Api\Config;

/**
 * Typed access to the attributes declared on a <ceQueue> in ce_mq.xml, for brokers and runners that
 * honour per-queue settings (retryInterval, maxRetries, leaseSeconds, ...).
 *
 * Separate from ConfigInterface so that adding it is not a BC break for that interface's implementers.
 *
 * @api
 */
interface QueueAttributesInterface
{
    /**
     * Raw attribute value as declared in ce_mq.xml (attributes merge as strings), or null when the
     * queue is not declared or does not set the attribute.
     */
    public function getQueueAttribute(string $queueName, string $attribute): ?string;
}
