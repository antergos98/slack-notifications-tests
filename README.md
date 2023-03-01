# Welcome to my Slack Notification Test Project!

Improvement I made is to add a Github Actions Workflow to the project to ensure that tests are always green and that the code is linted properly.

### How it works?

When sending a POST request to /api/notification the code will check if "Type" field is equal to `SpamNotification` using an Enum. If it is, we'll use a [library](https://github.com/spatie/laravel-slack-alerts) to send a slack alert to my personal Slack workspace. Workspace can be changed using the `SLACK_ALERT_WEBHOOK` environment variable in .env file

### Setup
```bash
composer install
php artisan key:generate
cp .env.example .env # You will have to put a Slack Webhook URL in SLACK_ALERT_WEBHOOK

php artisan serve
```

### Running tests
Tests won't send real Slack notifications

```bash
php artisan test
```