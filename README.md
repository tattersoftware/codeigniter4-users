# Tatter\Users
User interfaces and provider for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-users/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-users/actions/workflows/test.yml)
[![](https://github.com/tattersoftware/codeigniter4-users/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-users/actions/workflows/analyze.yml)
[![](https://github.com/tattersoftware/codeigniter4-users/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-users/actions/workflows/inspect.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-users/badge.svg?branch=develop)](https://coveralls.io/github/tattersoftware/codeigniter4-users?branch=develop)

## Quick Start

1. Install with Composer: `> composer require tatter/users`
2. Check the list of supported factories or provide your own
3. Access users and their methods through the provided service:
```
$users = service('users'); // instance of Tatter\Users\UserFactory
$user  = $users->findByEmail('bill@example.com'); // instance of Tatter\Users\UserEntity
echo $user->getUsername(); // "billy_jean"
```

## Description

Not an authentication module itself, `Tatter\Users` brings common interfaces and factory
discovery to simplify user integration into other libraries and projects.

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
* `> composer require tatter/workflows`

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

## Configuration

The core of **Users** are the interfaces for User Entities and User Factories. Your project
can use the built-in classes or provide its own implementation, and any library that uses
`Tatter\Users` will then be able to work with your user classes. Currently the following
libraries are supported natively and with discovery:
* [Myth:Auth](https://github.com/lonnieezell/myth-auth)
* [CodeIgniter Shield](https://github.com/lonnieezell/codigniter-shield) *(in development)*
* Agung Sugiarto's [CodeIgniter4 Authentication](https://github.com/agungsugiarto/codeigniter4-authentication)

Discovery will return the first `UserFactory` implementation it can locate with
the following priorities:

1. A `UserFactory` implementation called "UserModel" returned by the framework's model factory. Equivalent to:

	$users = model('UserModel', ['instanceOf' => UserFactory::class])

2. A discovered compatible library from `UserProvider`.

Note: If your implementation is not compatible with number one then you may supply it to
the provider directly:

	\Tatter\Users\UserProvider::addFactory(MyDiscoveryClass::class, MyFactory::class);

## Usage

Once you have the necessary classes available the easiest way to access them is through
the Users Service:
```
$users = service('users')->findByEmail('bill@example.com'); // instance of Tatter\Users\UserFactory
$user  = $users->findByEmail('bill@example.com'); // instance of Tatter\Users\UserEntity
```

## Factories

The User Factory interface defines the following methods:
* findById()
* findByEmail()
* findByUsername()

## Entities

The User Entity interface defines the following methods:
* getIdentifier()
* getId()
* getEmail()
* getUsername()
* getName()
* isActive()

There are extended interfaces in the `Tatter\Users\Interfaces` namespace that provide
additional methods which may be required by some libraries. Check your library's requirements
to make sure you are using all the required interfaces.

## Testing

There are convenience test cases in `Tatter\Users\Test` to enable other libraries to add
and test their own classes. If you are looking to test your user interfaces without committing
to a specific provider then consider adding [Tatter\Imposter](https://github.com/tattersoftware/codeigniter4-imposter) -
a mock authentication library that is fully compliant with `Tatter\Users`.

## Development

Pull Requests are accepted for additional libraries and adapters. Please include the appropriate
tests and provider code if you wish to support discovery. Requests for additional
implementations should be opened as a Feature Request Issue and fulfillment will depend on
availability and sponsorship (see "Sponsor this project").
