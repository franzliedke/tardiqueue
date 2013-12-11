<?php namespace Franzl\Tardiqueue;

use Illuminate\Queue\Queue;
use Illuminate\Queue\QueueInterface;

class DelayedQueue extends Queue implements QueueInterface {

	/**
	 * All jobs to be run at the end of the request.
	 *
	 * @var array
	 */
	protected $jobs = array();

	/**
	 * Push a new job onto the queue.
	 *
	 * @param  string  $job
	 * @param  mixed   $data
	 * @param  string  $queue
	 * @return mixed
	 */
	public function push($job, $data = '', $queue = null)
	{
		$this->jobs[] = array($job, $data);

		return 0;
	}

	/**
	 * Push a new job onto the queue after a delay.
	 *
	 * @param  \DateTime|int  $delay
	 * @param  string  $job
	 * @param  mixed  $data
	 * @param  string  $queue
	 * @return mixed
	 */
	public function later($delay, $job, $data = '', $queue = null)
	{
		return $this->push($job, $data, $queue);
	}

	/**
	 * Pop the next job off of the queue.
	 *
	 * @param  string  $queue
	 * @return \Illuminate\Queue\Jobs\Job|null
	 */
	public function pop($queue = null) {}

	/**
	 * Fire all queued jobs.
	 *
	 * @return void
	 */
	public function fireAll()
	{
		while ( ! empty($this->jobs))
		{
			list($job, $data) = array_shift($this->jobs);

			$this->resolveJob($job, $data)->fire();
		}
	}

	/**
	 * Resolve a Delayed job instance.
	 *
	 * @param  string  $job
	 * @param  string  $data
	 * @return \Franzl\Tardiqueue\DelayedJob
	 */
	protected function resolveJob($job, $data)
	{
		return new DelayedJob($this->container, $job, $data);
	}

}