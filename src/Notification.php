<?php

namespace KingsCode\AppCenter\Push;

use KingsCode\AppCenter\Push\Exceptions\PushNotificationException;

class Notification
{
    /**
     * The title.
     *
     * @var string
     */
    protected $title;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * The body.
     *
     * @var string
     */
    protected $body;

    /**
     * The custom data.
     *
     * @var array
     */
    protected $customData = [];

    /**
     * The data inside `notification_target`.
     *
     * @var array
     */
    protected $target = [];

    /**
     * The items to validate before trying to send a notification.
     *
     * @var array
     */
    protected $validatables = [
        'name', 'title', 'body',
    ];

    /**
     * Make a new notification.
     *
     * @return \KingsCode\AppCenter\Push\Notification
     */
    public static function make()
    {
        return new static();
    }

    /**
     * Get the notification as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $this->validate();

        $body = [
            'notification_content' => [
                'name'  => $this->name,
                'title' => $this->title,
                'body'  => $this->body,
            ],
        ];

        if (!empty($this->customData)) {
            $body['notification_content']['custom_data'] = $this->customData;
        }

        if (!empty($this->target)) {
            $body['notification_target'] = $this->target;
        }

        return $body;
    }

    /**
     * Validate the payload.
     *
     * @return void
     * @throws \KingsCode\AppCenter\Push\Exceptions\PushNotificationException
     */
    protected function validate()
    {
        $missing = [];

        foreach ($this->validatables as $item) {
            if (!isset($this->{$item})) {
                $missing[] = $item;
            }
        }

        if (!empty($missing)) {
            throw new PushNotificationException('Payload was incorrect, missing: "' . implode(' & ', $missing) . '"');
        }
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param array $customData
     * @return $this
     */
    public function setCustomData($customData)
    {
        $this->customData = $customData;

        return $this;
    }

    /**
     * @param array|string $devices
     * @return $this
     */
    public function setDevices($devices)
    {
        if (!is_array($devices)) {
            $devices = [$devices];
        }

        $this->devices = $devices;

        return $this;
    }

    /**
     * @param array $validatables
     * @return Notification
     */
    public function setValidatables($validatables)
    {
        $this->validatables = $validatables;

        return $this;
    }
}
