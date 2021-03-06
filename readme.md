#Admiral
[![Build Status](https://travis-ci.org/thepsion5/admiral.svg?branch=master)](https://travis-ci.org/thepsion5/admiral)
[![Coverage Status](https://coveralls.io/repos/thepsion5/admiral/badge.png?branch=master)](https://coveralls.io/r/thepsion5/admiral?branch=master)
A simple but flexible PHP implementation of the Command Bus pattern.
##Installation
Add the package to your composer.json file:
````json
{
    "require": {
        "thepsion5/admiral" : "dev-master"
    }
}
````
Then run `composer update`

##Basic Usage
In this context, a command is a DTO representing a single high-level instruction
for an application. Let's consider an application for managing music playlists.
We need four things:

1. A command class implementing `\Thepsion5\Admiral\CommandInterface`
2. A handler class implementing `\Thepsion5\Admiral\CommandHandlerInterface`
3. A class that creates the command instance and passes it to the Command Bus

###Create a Command
````php
class AddAlbumToLibraryCommand implements \Thepsion5\Admiral\CommandInterface
{
    public $albumName;
    public $artistId;
    public $songs = [];

    public function __construct($artistId, $albumName, array $songs)
    {
        $this->artistId = $artistId;
        $this->albumName = $albumName;
        $this->songs = $songs;
    }
}
````

###Create the Corresponding Command Handler
````php
class AddAlbumToLibraryCommandHandler implements \Thepsion5\Admiral\CommandHandlerInterface
{
    public function handle(AddAlbumToLibraryCommand $command)
    {
        //perform business logic here
    }
}
````

###Execute the Command
````php
class AdminController
{
    public function __construct()
    {
        $this->commandBus = \Thepsion5\Admiral\CommandBusFactory::makeCommandBus();
    }

    function postUploadAlbum($artistId)
    {
        $input = $this->input->post();
        $command = new AddAlbumToLibraryCommand($artistId, $input['title'], $input['songs']);
        $this->commandBus->execute($command);
    }
}
````

The Command Bus will automatically attempt to resolve the name of the command
class into a handler by replacing 'Command' with 'CommandHandler'. So,
`Acme\Domain\Albums\AddAlbumToLibraryCommand` will be translated to
`Acme\Domain\Albums\AddAlbumToLibraryCommandHandler`. Next, the
Command Bus will create the handler and return the results of
the `handle` function.

##Advanced Usage

###Manually Registering Command Handlers
If you have a different naming convention for commands and handlers, you may
register handlers manually:

````php
$resolver = $commandBus->getResolver();
$resolver->register('Acme\Commands\AddAlbumToLibrary', 'Acme\Handlers\AddAlbumToLibrary');
````

You can also use a custom resolver by implementing
`Thepsion5\Admiral\CommandHandlerResolverInterface` and setting it manually:

````php
$resolver = new AcmeCommandHandlerResolver();
$commandBus->setResolver($resolver);
````

###Dependency Injection in Handlers
For handlers with external dependencies, Admiral supports the use of Dependency
Injection using `illuminate/container`, the DI Container that powers the
Laravel framework. It can be accessed via the `getContainer()` method
on the command handler:

````php
$container = $commandBus->getResolver()->getContainer();
````

The container implements `Thepsion5\Admiral\Container\ContainerInterface`.
Bindings can be configured like so:

````php
$container->bind(
    'Acme\Domain\Albums\AlbumRepositoryInterface',
    '\Acme\Infrastructure\Albums\DbAlbumRepository'
);
//returns an instance of DbAlbumRepository
$repository = $container->make('Acme\Domain\Albums\AlbumRepositoryInterface');
````

###Using Other DI Containers

You can use a custom DI Container by creating an adapter that implements
`ContainerInterface`:
````php
$commandBus->getResolver()->setContainer(new SymfonyDiContainer);
````

##Access Control

Additional ACL functionality can be added to the Command Bus to provide fine-grained control
over who is capable of executing commands, without having to add that functionality to the
command handlers.

To use this feature, we need to use two additional components:

1. An `AccessControlCommandBus` instance
2. An `AccessPolicy` class

###Creating the Command Bus and Access Policy Class

The `AccessControlCommandBus` can be instantiated using the factory:
````php
$commandBus = \Thepsion5\Admiral\CommandBusFactory::makeAccessControlCommandBus();
````
This instance works no differently than the standard command bus but allows for the use of
an Access Policy Class. The method used to resolve it is similar to that used to resolve
the command handler. For example `CreateAlbumCommand` would look for a `CreateAlbumAccessPolicy`
in the same namespace.

Here's an example Access Policy class:
````php
class CreateAlbumAccessPolicy implements \Thepsion5\Admiral\AccessControl\AccessPolicyInterface
{
    public function assess(CommandInterface $command)
    {
        if(!Auth::user()) {
            throw new AccessControlException("You must be logged in to create an album.");
        } elseif(!Auth::user()->owns($command->artistId)) {
            throw new AccessControlException("You can only create Album for an artist you own.");
        }
    }
}
````

If no matching class is found, it will be ignored and the handler class will be called normally.

##Todo
* More documentation on Access Control
