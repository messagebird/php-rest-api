MessageBird's REST API for PHP
===============================
This repository contains the open source PHP client for MessageBird's REST API. Documentation can be found at: https://developers.messagebird.com/

[![Build Status](https://travis-ci.org/messagebird/php-rest-api.svg?branch=master)](https://travis-ci.org/messagebird/php-rest-api)
[![Latest Stable Version](https://poser.pugx.org/messagebird/php-rest-api/v/stable.svg)](https://packagist.org/packages/messagebird/php-rest-api)
[![License](https://poser.pugx.org/messagebird/php-rest-api/license.svg)](https://packagist.org/packages/messagebird/php-rest-api)

Requirements
-----

- [Sign up](https://www.messagebird.com/en/signup) for a free MessageBird account
- Create a new access_key in the developers sections
- MessageBird API client for PHP requires PHP >= 7.1.

Installation
-----

#### Composer installation

- [Download composer](https://getcomposer.org/doc/00-intro.md#installation-nix)
- Run `composer require messagebird/php-rest-api`.

#### Manual installation

When you do not use Composer. You can git checkout or download [this repository](https://github.com/messagebird/php-rest-api/archive/master.zip) and include the MessageBird API client manually.


Usage
-----

We have put some self-explanatory examples in the *examples* directory, but here is a quick breakdown on how it works. The examples expect the api key to be available in the env var MESSAGEBIRD_API_KEY. So make sure to set it when running the example.

```php
require 'autoload.php';

$MessageBird = new \MessageBird\Client(getenv('MESSAGEBIRD_API_KEY'));
```

Run your script with:
```sh
MESSAGEBIRD_API_KEY={your API key here} php your-script.php
```

That's easy enough. Now we can query the server for information. Lets use getting your balance overview as an example:

```php
// Get your balance
$Balance = $MessageBird->balance->read();
```


Conversations Whatsapp Sandbox
-------------

To use the whatsapp sandbox you need to add `\MessageBird\Client::ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX` to the list of features you want enabled. Don't forget to set the env var MESSAGEBIRD_API_KEY when running the example.

```php
$messageBird = new \MessageBird\Client(getenv('MESSAGEBIRD_API_KEY'), null, [\MessageBird\Client::ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX]);
```

If you use a custom `HttpClient` you will have to manually direct Conversation API request to the WhatsApp sandbox endpoint.


Documentation
----
Complete documentation, instructions, and examples are available at:
[https://developers.messagebird.com/](https://developers.messagebird.com/)


License
----
The MessageBird REST Client for PHP is licensed under [The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause). Copyright (c) 2014, MessageBird
