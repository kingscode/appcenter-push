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
     * Whether the notification should be a silent notification.
     *
     * @var bool
     */
    protected $silent = false;

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
    public function setCustomData(array $customData)
    {
        $this->customData = $customData;

        return $this;
    }
    
    /**
     * @param array $target
     * @return $this
     */
    public function setTarget(array $target)
    {
        $this->target = $target;
        
        return $this;
    }
}
