# Test Task

Notes
1) I used queue database connection to not add additional information about configuring redis. But I prefer using redis for queues.
2) Please run `php artisan queue:work` command to listen queues.
3) Please run `php artisan subscribers:notify` to notify users about new posts.
4) Please run `php artisan migrate --seed` to run migrations and seeder of websites.
5) I didn't use cache because there's no reason for this task.
6) I have created Postman collection.
