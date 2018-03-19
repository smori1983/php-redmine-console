<?php
namespace Momo\Redmine\Http;

use Symfony\Component\BrowserKit\Client as BaseClient;
use Symfony\Component\BrowserKit\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

class Client extends BaseClient
{
    protected function doRequest($request)
    {
        $client = new GuzzleClient([
            'verify' => false,
        ]);

        $params = [];

        $cookieJar = new CookieJar();

        foreach ($this->getCookieJar()->all() as $cookie ) {
            $cookieJar->setCookie(SetCookie::fromString((string) $cookie));
        }

        $params['cookies'] = $cookieJar;

        if ($request->getMethod() === 'POST') {
            $params['form_params'] = $request->getParameters();
        }

        $response = $client->request($request->getMethod(), $request->getUri(), $params);

        return new Response(
            $response->getBody(),
            $response->getStatusCode(),
            $response->getHeaders()
        );
    }
}
