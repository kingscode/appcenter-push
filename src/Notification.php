<?php

namespace KingsCode\AppCenter\Push;

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
        if ($this->isSilent()) {
            return $this->buildSilentNotification();
        }

        return $this->buildLoudNotification();
    }

    /**
     * Build a loud notification.
     *
     * @return array
     */
    public function buildLoudNotification()
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
     * Build a silent notification.
     *
     * @return array
     */
    public function buildSilentNotification()
    {
        $body = [
            'notification_content' => [
                'name'        => $this->name,
                'title'       => null,
                'body'        => null,
                'custom_data' => array_merge(['content-available' => 1], $this->customData),
            ],
        ];

        if (!empty($this->target)) {
            $body['notification_target'] = $this->target;
        }

        return $body;
    }

    /**
     * Make the notification silent.
     *
     * @return $this
     */
    public function silent()
    {
        $this->silent = true;

        return $this;
    }

    /**
     * Make the notification loud, e.g. not silent.
     *
     * @return $this
     */
    public function loud()
    {
        $this->silent = false;

        return $this;
    }

    /**
     * Whether the application is silent.
     *
     * @return bool
     */
    public function isSilent()
    {
        return $this->silent;
    }

    /**
     * Whether the application is loud.
     *
     * @return bool
     */
    public function isLoud()
    {
        return $this->silent;
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
