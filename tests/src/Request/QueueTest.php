<?php declare(strict_types=1);

namespace coro\Fio\Request;

use GuzzleHttp;
use coro\Fio\Test\ClientMock;
use coro\Fio\Test\Response;
use Salamium\Testinium\File;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

class QueueTest extends \Tester\TestCase
{

	private const TOKEN = 'test_test_test_test_test_test_test';


	/**
	 * @throws \coro\Fio\Exceptions\ServiceUnavailable
	 */
	public function testDownloadThrowServiceUnavailable()
	{
		$queue = self::createQueue();
		$queue->setDownloadOptions([
			Response::RESPONSE_CODE => 500,
		]);
		$queue->download(self::TOKEN, 'http://www.example.com/');
	}


	/**
	 * @throws GuzzleHttp\Exception\ClientException
	 */
	public function testDownloadThrowClientException()
	{
		$queue = self::createQueue();
		$queue->setDownloadOptions([
			Response::EXCEPTION_CLASS => GuzzleHttp\Exception\ClientException::class,
		]);
		$queue->download(self::TOKEN, 'http://www.example.com/');
	}


	/**
	 * @throws \coro\Fio\Exceptions\ServiceUnavailable
	 */
	public function testDownloadThrowServerException()
	{
		$queue = self::createQueue();
		$queue->setDownloadOptions([
			Response::EXCEPTION_CLASS => GuzzleHttp\Exception\ServerException::class,
		]);
		$queue->download(self::TOKEN, 'http://www.example.com/');
	}


	public function testDownloadOk()
	{
		$queue = self::createQueue();
		$xml = $queue->download(self::TOKEN, 'http://www.example.com/');
		Assert::same(File::load('payment/response.xml'), $xml);
	}


	/**
	 * @throws \coro\Fio\Exceptions\QueueLimit
	 */
	public function testDownloadThrowQueueLimit()
	{
		$queue = self::createQueue();
		$queue->setSleep(true);
		$queue->setDownloadOptions([
			Response::RESPONSE_CODE => Queue::HEADER_CONFLICT,
			Response::EXCEPTION_CLASS => GuzzleHttp\Exception\ClientException::class,
		]);
		$queue->download(self::TOKEN, 'http://www.example.com/');
	}


	public function testUpload()
	{
		$queue = self::createQueue();
		$xml = $queue->upload('http://www.example.com/', self::TOKEN, [
			'type' => 'xml',
		], __DIR__ . '/../../data/tests/payment/euro-minimum.xml');

		Assert::true($xml->isOk());
	}


	private static function createQueue(): QueueMock
	{
		$q = new QueueMock(__DIR__ . '/../../temp');
		$q->setLimitLoop(2);
		$q->setSleep(false);
		return $q;
	}

}

class QueueMock extends Queue
{

	public const WAIT_TIME = 2;


	protected function createClient(): GuzzleHttp\ClientInterface
	{
		return new ClientMock();
	}


	protected static function waitTime(): int
	{
		return 2;
	}
}

(new QueueTest())->run();
