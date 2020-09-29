<?php declare(strict_types=1);

namespace coro\Fio\Response\Read;

use coro\Fio\Response\Pay\XMLResponse;
use Salamium\Testinium;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @author Martin Pecha
 */
class ServerExceptionTest extends Tester\TestCase
{

	public function testResponse()
	{
		$xml = Testinium\File::load('server-exception.xml');
		$xmlResponse = new XMLResponse($xml);
		Assert::false($xmlResponse->isOk());
	}

}

(new ServerExceptionTest())->run();
