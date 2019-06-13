# Apitte Presenter

Integrate [Apitte](https://github.com/apitte/core) into [nette/routing](https://github.com/nette/routing) with a presenter. 

> Usage of that package is not recommended as it requires unnecessary conversion of nette request into psr-7 request.
> It also adds headers from nette response configuration which are usually mean for UI, not an API.

> Presenter is currently incompatible with [middlewares](https://github.com/apitte/middlewares).

## Content

- [Setup](setup)

## Setup

First of all, setup [core](https://github.com/apitte/core) package.

Install `apitte/presenter`

```bash
composer require apitte/presenter
```

Configure presenter mapping

```yaml
application:
    mapping:
        Apitte: Apitte\Presenter\*Presenter
```

Prepend `ApiRoute` to your router. Therefore you can reach your API at `<project>/api`.

```php
namespace App\Router;

use Apitte\Presenter\ApiRoute;
use Nette\Application\IRouter;
use Nette\StaticClass;

class RouterFactory
{
    use StaticClass;

    public static function createRouter(): IRouter
    {
        $router = new RouteList;
        $router[] = new ApiRoute('api');
        $router[] = new Route('<presenter>/<action>', 'Homepage:default');
        return $router;
    }
}
```

In `index.php` drop `Apitte\Core\Application\IApplication` and keep `Nette\Application\Application` only.
