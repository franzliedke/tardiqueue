<?php namespace Franzl\Tardiqueue;

use Illuminate\Queue\Connectors\ConnectorInterface;

class DelayedConnector implements ConnectorInterface {

	/**
	 * The queue processor instance to be shared.
	 *
	 * @var \Franzl\Tardiqueue\Processor
	 */
	protected $processor;

	/**
	 * Create a new connector instance.
	 *
	 * @param  \Franzl\Tardiqueue\Processor  $processor
	 */
	public function __construct(Processor $processor)
	{
		$this->processor = $processor;
	}

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		$queue = new DelayedQueue;
		$this->processor->register($queue);

		return $queue;
	}

}