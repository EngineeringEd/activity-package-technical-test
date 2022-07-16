# Activity package technical test

For this test you will be asked to build a simple Laravel package for logging
user activity on models, so they can see a history of their data.

## Introduction
It is a very useful feature of web applications to be able to show users how and
when their data was changed throughout the lifetime of their account. Laravel
has many features that make keeping track of activity easier through events.  
The package should be easy to use out of the box but contain some customisation
options to tailor it to specific applications.  
There will also be some follow-up questions asking how the package might be
improved with more development.

## Test specifications
There are a number of things that this package should have:
- The means to create a table for storing the user activity (with the possibility for the developer to change the migration)
- A model called `Action` that relates to this table and holds the logic for an individual event
    - An action should know the type of action (create, update, delete)
    - Each action should be related to a "performer" model and a "subject" model
        - For simplicity, you can assume that any application using this package would have a `users` table and that the `User` model is the "performer"
        - You can assume that the performer is the currently authenticated user
        - The "subject" model could be any/all models defined in the application (including the `User`)
    - An action should be able to output a translated string summarising the action, including whoever performed the action and the item that it was performed on
- A trait called `HasActions` to be added to the models that should have their events recorded into actions
    - The trait should allow the developer to access all actions performed on an item
    - The logic for generating actions based on Laravel events should be in the trait
- A trait called `PerformsActions` which can be added to the `User` to allow the developer to easily fetch the users activity
- Tests verifying the behaviour, the Laravel Package test framework [orchestra](https://packages.tools/testbench) is already installed and set up.

## Developing the package
Feel free to fork this repository to get a base for the package. Some needed
folders are already generated as well as some empty test cases to be filled in.

When you have completed it, the test suite should be passing, and it should be
usable in a new Laravel project.

### Requirements
This is a very basic project which doesn't require anything more than the
minimum for a Laravel project.  
You can get it running inside a
[Homestead](https://laravel.com/docs/9.x/homestead#main-content) virtual machine
or on any machine with the following software:
- PHP >= 8.0
- Composer >= 2.0
- SQlite with the PHP extension

### Installation
To get started with this project:
1. fork it into your GitHub account
2. Clone the forked repository onto your PC
3. `cd` into the cloned repository
4. Run `composer install`
5. Run `composer test` -> You should see all tests failing

## Considerations
There are a few things we are looking out for in the code:
- Self commenting code where possible and clear comments if not
- Sensible well-thought-out approach to the problems in the test
- Not reinventing the wheel, using existing functions/services when it makes sense
- Consideration for large scale data (millions of actions)
- Efficiency when it makes sense (i.e. no need to save a few milliseconds at the expense of readability)

## Questions for further development
This test should only be a very basic implementation of the package, not
production ready.  
Following are some questions about making it a more complete package and some
other considerations that could be included.

You may write the answers in this README as part of the submission. (If you want
to implement the answer to some of these questions in the code then feel free,
with some comments referencing the question and giving some context).

1. What aspects of this package could be customised with a config file
- dsn transport (should really not have this clogging up the main thread of an app)
- Action name (could be better as AuditTrail or Amendment)
- output (could change this so it writes out to logs rather than DB)
- Custom events (limiting to just Model events means we have to work with entities)

2. How would you go about storing more information about the event (i.e. what fields were updated, from what to what)?
We could store a JSON blob of the fields that where changed on the current model. This would then mean that the previous state of the model would be contained in the event prior to the current, allowing for easy rewind if ever it was needed.

3. How would you increase the security of the package, ensuring only authorised performers can see the activity for an item?
We have the performer_id so we could register middlewares on any API endpoints attempting to access resources and authorise them to do so. An Access Policy would also be required too. Laravel provides Gates and polcieis to achieve this.

4. If a performer or item is deleted from the system, what would their actions say in their summary? How could this be improved?
If a performer is deleted, its performedActions would still need to exist. So softDeletes should be implemented to prevent foreign key issues. For a subject, the message currently does not express who did this or why. So, it could be useful to include tag or reason code for the operation carried out. Currently, the descriptions are also hard coded and not dynamic; so adding slots so we can interpolate values could be useful. Laravel provides this using __() or trans() and passing a 2nd arg of an associative array.

5. Suppose the developer wants to record other types of actions that are more specific, i.e. "Task was completed by ____" how could that be implemented?
As mentioned above, we can use slots with the ':{NAME_OF_FIELD}' syntax and pass an associative array as an input to __() or trans().

6. What should be considered when developing the package to scale?
- Frequency of events
- Processing power of writes to DB
- Queing workload to avoid bottlenecks in the app
- DB space (NoSQL would be ideal for this, especially if JSON blob is implemented with fields changed on Action)
- How to make it easy for the developer to opt out of certain events (they may not want to send a signal for every read of a resource)

7. What should happen when an event is triggered but there is no authenticated user, e.g. in a queued job?
If we made the morphs on the performer nullable in the migration, we could have it so that the events that use auth() could use optionals or nullish coalesence to check if the user even exists. This is a quick solution, but is awful from a security point of view. We can have our workers authenticate with the server by using config. If we were running this in a Kubernetes cluster for example, we could store encrptyed credentials for workers to use to authenticate. This would mean we could see exactly what workers did what job for example.

## Links that may be useful
- https://laravel.com/docs/9.x/eloquent#events-using-closures
- https://www.archybold.com/blog/post/booting-eloquent-model-traits
- https://laravel.com/docs/9.x/eloquent-relationships
