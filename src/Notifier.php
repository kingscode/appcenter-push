<?php

namespace KingsCode\AppCenter\Push;

use KingsCode\AppCenter\Push\Exceptions\PushNotificationException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Notifier
{
    /**
     * The client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * The token.
     *
     * @var string
     */
    protected $token;

    /**
     * The owner name.
     *
     * @var string
     */
    protected $ownerName;

    /**
     * The app name.
     *
     * @var string
     */
    protected $appName;

    /**
     * The base url.
     *
     * @var string
     */
    protected $baseUrl = 'https://api.appcenter.ms';

    /**
     * The push notification uri.
     *
     * @var string
     */
    protected $pushNotificationUri = '/v0.1/apps/{owner_name}/{app_name}/push/notifications';

    /**
     * Notifier constructor.
     *
     * @param \GuzzleHttp\Client $client
     * @param array              $settings
     */
    public function __construct(Client $client, array $settings = [])
    {
        $this->setClient($client);

        if (!empty($settings)) {
            $this->setSettingsFromArray($settings);
        }
    }

    /**
     * Send the given notification payload.
     *
     * @param \KingsCode\AppCenter\Push\Notification $notification
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(Notification $notification)
    {
        return $this->client->request('POST', $this->getUrl(), [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'X-API-Token'  => $this->token,
            ],
            'json'    => $notification->toArray(),
        ]);
    }

    /**
     * Get the push notification url.
     *
     * @return string
     * @throws \KingsCode\AppCenter\Push\Exceptions\PushNotificationException
     */
    protected function getUrl()
    {
        if (empty($ownerName = $this->ownerName)) {
            throw new PushNotificationException('Have you set the Owner Name?');
        }

        if (empty($appName = $this->appName)) {
            throw new PushNotificationException('Have you set the App Name?');
        }

        $uri = $this->pushNotificationUri;

        $uri = str_replace('{owner_name}', $ownerName, $uri);
        $uri = str_replace('{app_name}', $appName, $uri);

        return $this->baseUrl . $uri;
    }

    /**
     * Set the settings from array.
     *
     * @param array $settings
     * @return void
     */
    protected function setSettingsFromArray(array $settings)
    {
        $this->setToken(
            isset($settings['token']) ? $settings['token'] : null
        );

        $this->setOwnerName(
            isset($settings['owner_name']) ? $settings['owner_name'] : null
        );

        $this->setAppName(
            isset($settings['app_name']) ? $settings['app_name'] : null
        );
    }

    /**
     * Set the client.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set the token.
     *
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set the base url.
     *
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param string $ownerName
     * @return Notifier
     */
    public function setOwnerName($ownerName)
    {
        $this->ownerName = $ownerName;

        return $this;
    }

    /**
     * @param string $appName
     * @return Notifier
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;

        return $this;
    }

    /**
     * @param string $pushNotificationUri
     * @return Notifier
     */
    public function setPushNotificationUri($pushNotificationUri)
    {
        $this->pushNotificationUri = $pushNotificationUri;

        return $this;
    }

    /**
     * Make a new Notifier instance.
     *
     * @param array $settings
     * @return static
     */
    public static function make(array $settings = [])
    {
        return new static(new Client(), $settings);
    }
}
