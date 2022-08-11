# Initialization
1. Run `composer install` to install the vendor dependencies.
2. Copy the `.env.example` file to `.env` and set your `DB_HOST` credentials and your `MAIL_HOST` as well.
3. Run `php artisan key:generate` to generate your app key.
4. Run `npm install` to install the node dependencies.
5. Run `php artisan webpush:vapid` to generate your VAPID keys on the `.env` file.
6. Run `php artisan migrate` to create the database.
7. Copy the `VAPID_PUBLIC_KEY` in the `public/js/enable.notifications.js` file at `line 55` (`subscribeUser` function).
8. Run `npm run build` to build the application.
9. Run `php artisan serve` to serve the application at `localhost:8000`.
