# PHP AppCenter Push
[![Packagist](https://img.shields.io/packagist/v/kingscode/appcenter-push.svg?colorB=brightgreen)](https://packagist.org/packages/kingscode/appcenter-push)
[![license](https://img.shields.io/github/license/kingscode/appcenter-push.svg?colorB=brightgreen)](https://github.com/kingscode/appcenter-push)
[![Packagist](https://img.shields.io/packagist/dt/kingscode/appcenter-push.svg?colorB=brightgreen)](https://packagist.org/packages/kingscode/appcenter-push)

PHP AppCenter Push client.

## Installation
Require the package.
```sh
composer require kingscode/appcenter-push
```

## Usage

```php
// Create a notifier...
$notifier = Notifier::make()
    ->setOwnerName($ownerName) // Set the owner name.
    ->setAppName($appName)     // Set the app name.
    ->setToken($token);        // Set the api token.

// Create a notification...
$notification = Notification::make()
    ->setName($name)   //Set the notification name.
    ->setTitle($title) //Set the notification title.
    ->setBody($body);  //Set the notification body.
    
// And send the notification...
$notifier->send($notification);
```
