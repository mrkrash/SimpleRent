# SimpleRent
## A simple booking web software without any claim

This software, which started as a small demonstration website, aims to rent bicycle products (bicycles, helmets,
pedals..).

There are many electronic carts but, the need was for something simple, that would do just three things and be 
maintainable in the long run.

### The Three Things
- Being a showcase for the rental store;
- Allow users to rent a bike and its accessories in three easy steps;
- Provide users with information such as events and routes.

### Technology
The choice fell on the [Symfony](https://symfony.com) framework, using only the strictly necessary libraries, making the
crud by hand, just for the pleasure of writing some code and not depending too much on various bundles.

Initially, the code respected the [MVC](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) paradigm, 
but as the code evolved, a [DDD](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) approach was 
decided upon.

### Developing
To enable local development, without the need for containers, [SQLite](https://www.sqlite.org) is used. This implies 
that migrations created locally, are only fine locally.

To make changes to the database in production, it will then be necessary to produce migrations suitable for the chosen 
database (in my case [MariaDB](https://mariadb.org/)).

Nothing prohibits the use of SQLite, a database that is more than reliable and sufficient to be able to handle medium 
workloads.