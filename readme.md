[![Get help on Codementor](https://cdn.codementor.io/badges/get_help_github.svg)](https://www.codementor.io/cmgmyr)

#SlickVoice (MVP)
Invoicing and payment service built with Lavavel and Stripe.

This was built as a part of a presentation for the [TrianglePHP](http://www.meetup.com/trianglephp/events/228308536/) Meetup group - [Joind.in](https://joind.in/talk/ab6ad) | [Slides](https://speakerdeck.com/cmgmyr/building-your-first-mvp-in-laravel)

To run this app:

1. Clone Repo, Install [Homestead](https://laravel.com/docs/5.2/homestead), set up new site in Homestead.
2. Create new database in Homestead
3. Copy the `.env` file: `cp .env.example .env`
4. Update your `.env` file with your changes (app key, database, queue, stripe, email, etc)
5. Run `php artisan migrate`
6. Create your user for logging in with a seeder, `artisan tinker`, or through the database.
7. Open the homestead site in a browser and enjoy!

## Questions, comments, help?
Please feel free to submit a GitHub "issue" on this repo, reach out via [email](mailto:cmgmyr@gmail.com) or [twitter](https://twitter.com/cmgmyr), or get additional one-on-one help with me through [CodeMentor](https://www.codementor.io/cmgmyr).
