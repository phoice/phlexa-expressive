# phlexa-expressive

Build voice applications for Amazon Alexa with phlexa, PHP and Zend\Expressive.

# Zend Framework Library for Amazon Alexa Skills

This library depends on phlexa, the library for building your own PHP based 
Amazon Alexa skills. It adds a couple of useful factory classes based on 
`Zend\ServiceManager` and some middleware classes ready to use for your 
middleware pipeline. It also contains an Intent-Manager based on 
`Zend\ServiceManager` to make intent class handling as easy as possible for 
your applications.

## Dependencies

* PHP 7
* https://github.com/php-fig/http-message-util
* https://github.com/http-interop/http-middleware
* https://github.com/php-fig/container
* https://github.com/php-fig/http-message
* https://github.com/phoice/phlexa
* https://github.com/zendframework/zend-expressive-router
* https://github.com/zendframework/zend-expressive-template
* https://github.com/zendframework/zend-servicemanager

## Installation

Install it in your PHP project simply with Composer:

```
composer require phoice/phlexa-expressive
```

## Usage

To get started with this library please refer to the Amazon Alexs Skill Skeleton:

https://github.com/phoice/phlexa-expressive-skeleton
