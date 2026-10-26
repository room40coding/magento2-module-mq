<?php

namespace Rcason\Mq\Api;

use Rcason\Mq\Api\Data\MessageEnvelopeInterface;

/**
 * @api
 */
interface BrokerInterface
{
    /**
     * Add message to queue
     * 
     * @return void
     */
    public function enqueue(MessageEnvelopeInterface $message);
    
    /**
     * Hand out the next message in the queue.
     *
     * A broker that supports concurrent consumers of one queue does not merely read the message:
     * it claims it for this consumer (a lease), so no other consumer is handed the same message
     * until the claim is released by acknowledge()/reject() or lapses. Keep the returned envelope
     * and pass that same instance back; it carries the claim.
     * 
     * @return \Rcason\Mq\Api\Data\MessageEnvelopeInterface|false|null Falsy when nothing is runnable.
     */
    public function peek();
    
    /**
     * Mark message as processed.
     *
     * A claiming broker may throw when its claim on the message has been lost (the lease lapsed and
     * another consumer took the message); nothing is changed in that case.
     * 
     * @return void
     */
    public function acknowledge(MessageEnvelopeInterface $message);
    
    /**
     * Reject message: return it to the queue ($requeue) or discard it.
     *
     * Implementations may accept further optional arguments (e.g. `int $maxRetries = 0,
     * int $retryInterval = 0` for backoff and dead-lettering). Same claim-lost caveat as acknowledge().
     * 
     * @return void
     */
    public function reject(MessageEnvelopeInterface $message, bool $requeue);
}
