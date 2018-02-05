# PHP AppCenter Push
PHP AppCenter Push client.

## Installation
Require the package.
```sh
composer require kingscode/app-center-push
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
