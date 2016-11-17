# CQRS Framework #

The goal of this framework is to enable us to quickly bootstrap new CQRS Services while sticking to our very strict coding guidelines. This especially means that any kind of magic should be avoided.

## Components ##

### Request

- Currently Supports only HTTP `get` and `post` verbs. 

### PostRoute

- Determines if it is responsible for routing a given URL.
- Returns a `Command`

### Command

- Changes the state of a resource (like creating or updating)

### GetRoute

- Determines if it is responsible for routing a given URL.
- Returns a `Query`

### Query

- Does not change the state of a resource and only returns existing data.

## Using the Framework

### Requirements

- Composer
- PHP 7.0+

### Add the Framework to your composer.json:
```
	"require": {
		"kartenmacherei/http-framework": "dev-master"
	}
```

### Connect your code to the Framework:
```php
// create a request
$request = Request::fromSuperGlobals();

// create a new instance of the framework
$framework = Framework::createInstance();

// register a Request Route
$framework->registerPostRoute(new LoginRoute());
$framework->registerGetRoute(new WelcomeRoute());

// let the framework process the request
$response = $framework->run($request);

// send the response to the client
$response->flush();
```

## License

This software is licensed under the terms of the [MIT license](https://opensource.org/licenses/MIT). See LICENSE.md for the full license.