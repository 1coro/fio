<?php declare(strict_types=1);

namespace coro\Fio\Request;

use coro\Fio\Response;

interface IQueue
{

	/** @var int [s] */
	const WAIT_TIME = 30;
	const HEADER_CONFLICT = 409;

	/**
	 * Return raw data from source.
	 */
	function download(string $token, string $url): string;


	function upload(string $url, string $token, array $post, string $filename): Response\Pay\IResponse;

}
