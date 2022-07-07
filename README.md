MessageBird's REST API for PHP
===============================
This repository contains the open source PHP client for MessageBird's REST API. Documentation can be found at: https://developers.messagebird.com/

[![Build Status](https://github.com/messagebird/php-rest-api/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/messagebird/php-rest-api/actions/workflows/tests.yml?query=branch%3Amaster)
[![Latest Stable Version](https://poser.pugx.org/messagebird/php-rest-api/v/stable.svg)](https://packagist.org/packages/messagebird/php-rest-api)
[![License](https://poser.pugx.org/messagebird/php-rest-api/license.svg)](https://packagist.org/packages/messagebird/php-rest-api)

Requirements
-----

- [Sign up](https://www.messagebird.com/en/signup) for a free MessageBird account
- Create a new access_key in the developers sections
- MessageBird API client for PHP requires PHP >= 7.3.

Installation
-----

#### Composer installation

- [Download composer](https://getcomposer.org/doc/00-intro.md#installation-nix)
- Run `composer require messagebird/php-rest-api`.

#### Manual installation

When you do not use Composer. You can git checkout or download [this repository](https://github.com/messagebird/php-rest-api/archive/master.zip) and include the MessageBird API client manually.


Usage
-----

We have put some self-explanatory examples in the *examples* directory, but here is a quick breakdown on how it works. First, you need to set up a **MessageBird\Client**. Be sure to replace **YOUR_ACCESS_KEY** with something real.

```php
require 'autoload.php';

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY');

```

That's easy enough. Now we can query the server for information. Lets use getting your balance overview as an example:

```php
// Get your balance
$balance = $messageBird->balance->read();
```


Documentation
----
Complete documentation, instructions, and examples are available at:
[https://developers.messagebird.com/](https://developers.messagebird.com/)


License
----
The MessageBird REST Client for PHP is licensed under [The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause). Copyright (c) 2014, MessageBird
