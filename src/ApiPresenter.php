<?php declare(strict_types = 1);

namespace Apitte\Presenter;

use Apitte\Core\Dispatcher\IDispatcher;
use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ServerRequestFactory;
use Contributte\Psr7\Psr7Uri;
use Nette\Application\IPresenter;
use Nette\Application\IResponse;
use Nette\Application\Request;
use Nette\Http\Request as HttpRequest;

class ApiPresenter implements IPresenter
{

	/** @var IDispatcher */
	private $dispatcher;

	/** @var HttpRequest */
	private $request;

	public function __construct(IDispatcher $dispatcher, HttpRequest $request)
	{
		$this->dispatcher = $dispatcher;
		$this->request = $request;
	}

	public function run(Request $request): IResponse
	{
		$url = $this->request->getUrl();
		$url = substr($url->getPath(), strlen($url->getScriptPath()));

		$request = Psr7ServerRequestFactory::fromNette($this->request)
			->withUri(new Psr7Uri($url));

		$response = new Psr7Response();
		$response = $this->dispatcher->dispatch($request, $response);

		return new ApiResponse($response);
	}

}
