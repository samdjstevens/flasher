# Flasher

A simple PHP (5.3+) package to ease the process of displaying feedback to users of your website as they interact with it.

This package comes in handy when you want to provide some feedback to the user on the next page load, after they complete certain actions on your site. For example, a messaging confirming that they have successfully signed up, or deleted their account.

## Installation

The easiest and best way to install the package is via [Composer](http://getcomposer.org). 
Add the ```spanky/flasher``` package to your requirements, and ```composer install```.

```json
{
    "require": {
        "spanky/flasher": "dev-master"
    }
}
``` 
Once the package has been installed, ensure the Composer autoloader is required before 
trying to use Flasher.

```php
    require 'vendor/autoload.php';
```


## Usage

To get up and running, first we need to make an instance of the ```Spanky\Flasher\FlasherManager``` class. 

To do so, simply call the ```make()``` method on the ```Spanky\Flasher\Factory``` class.

```php
<?php

use Spanky\Flasher\Factory as Flasher;

$flasher = Flasher::make();
```

If using the ```Spanky\Flasher\MessageStore\SessionMessageStore``` implementation (the default) to 
store messages between page loads, ensure that the session is started before initialising the package:

```php
session_start();
```

### Setting messages

To set a message to be displayed on the next page load, call the ```addMessage()``` method, 
passing in the content of the message.

```php
$flasher->addMessage('Welcome to the website!');

$flasher->addMessage('Congratulations, you are now signed up!', 'success');

$flasher->addMessage('Oh no, something went wrong!', 'error');
```
The first parameter is the content of the message you wish to be displayed to the user. This must 
be either a string, or an object implementing the ```__toString()``` method.

Notice how you can specify an optional string to denote the type of message being provided as 
either the second parameter of the ```addMessage()``` method.

If you wish, you can also add messages of a specific type in the following way:

```php
$flasher->addSuccess('Congratulations, you are now signed up!');
// identical to $flasher->addMessage('Congratulations, you are now signed up!', 'success');
```

### Displaying messages

When it comes to actually displaying the messages to the user, there are a few methods to 
help you do this with the most flexibility.


```php
if ($flasher->hasMessages()) 
{
    echo '<ul>';
    foreach($flasher->getMessages() as $message) 
    {
        echo '<li class="'.$message->getType().'">', $message, '</li>';
    }
    echo '</ul>';
}
```

First, we check if there are any messages to display using the ```hasMessages()``` method, which 
returns either ```true``` or ```false``` depending on whether or not there are messages to show.

If there are messages, then we retrieve them by calling the ```getMessages``` method, which returns 
an instance of ```Spanky\Flasher\Collections\MessageCollection```, containing 
```Spanky\Flasher\FlashMessage``` objects representing the messages.

The type of a message can be retrieved by calling the ```getType()``` method on the object, and the 
actual content by calling the ```getContent()``` method, or casting the object to a string.

#### Displaying only messages of a certain type

To only check for, or display, messages of a certain type, pass the type string into 
the ```hasMessages()``` and ```getMessages()``` methods, like so:

```php
if ($flasher->hasMessages('success')) 
{
    echo '<ul>';
    foreach($flasher->getMessages('success') as $message) 
    {
        echo '<li class="'.$message->getType().'">', $message, '</li>';
    }
    echo '</ul>';
}
```

#### Displaying only the first, or last message

In some instances, you might not want to display all the messages, but just the first, or last.
You can do this easily, by using the ```first()``` or ```last()``` methods on the 
```Spanky\Flasher\Collections\MessageCollection``` class.

```php
if ($flasher->hasMessages('error')) 
{
    echo '<div class="error"><strong>', $flasher->getMessages('error')->first(), '</strong></div>';
}
```

## Tests

Run ```phpunit``` to trigger the test suite.


