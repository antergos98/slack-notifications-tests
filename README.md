# Welcome to my Slack Notification Test Project!

Improvement I made is to add a Github Actions Workflow to the project to ensure that tests are always green and that the code is linted properly.

### How it works?

When sending a POST request to /api/notification the code will check if "Type" field is equal to `SpamNotification` using an Enum. If it is, we'll use a [library](https://github.com/spatie/laravel-slack-alerts) to send a slack alert to my personal Slack workspace. Workspace can be changed using the `SLACK_ALERT_WEBHOOK` environment variable in .env file

It is possible to test it out for real using Postman or Insomnia:

POST http://localhost:8000/api/notification

With header: Content-Type = application/json

```json
{
  "RecordType": "Bounce",
  "Type": "SpamNotification",
  "TypeCode": 512,
  "Name": "Spam notification",
  "Tag": "",
  "MessageStream": "outbound",
  "Description": "The message was delivered, but was either blocked by the user, or classified as spam, bulk mail, or had rejected content.",
  "Email": "zaphod@example.com",
  "From": "notifications@honeybadger.io",
  "BouncedAt": "2023-02-27T21:41:30Z"
}
```

### Setup
```bash
composer install
cp .env.example .env # You will have to put a Slack Webhook URL in SLACK_ALERT_WEBHOOK
php artisan key:generate
php artisan serve
```

### Running tests
Tests won't send real Slack notifications

```bash
php artisan test
```