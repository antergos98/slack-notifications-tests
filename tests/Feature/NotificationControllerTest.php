<?php

namespace Tests\Feature;

use Spatie\SlackAlerts\Facades\SlackAlert;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    public static function validationDataProvider(): array
    {
        return [
            [
                'Email', [
                    'RecordType' => 'Bounce',
                    'Type' => 'SpamNotification',
                    'TypeCode' => 512,
                    'Name' => 'Spam notification',
                    'Tag' => '',
                    'MessageStream' => 'outbound',
                    'Description' => 'The message was delivered, but was either blocked by the user, or classified as spam, bulk mail, or had rejected content.',
                    'Email' => null,
                    'From' => 'notifications@honeybadger.io',
                    'BouncedAt' => '2023-02-27T21:41:30Z',
                ],
            ],
            [
                'Email', [
                    'RecordType' => 'Bounce',
                    'Type' => 'SpamNotification',
                    'TypeCode' => 512,
                    'Name' => 'Spam notification',
                    'Tag' => '',
                    'MessageStream' => 'outbound',
                    'Description' => 'The message was delivered, but was either blocked by the user, or classified as spam, bulk mail, or had rejected content.',
                    'Email' => 'not_an_email',
                    'From' => 'notifications@honeybadger.io',
                    'BouncedAt' => '2023-02-27T21:41:30Z',
                ],
            ],
            [
                'Type', [
                    'RecordType' => 'Bounce',
                    'Type' => null,
                    'TypeCode' => 512,
                    'Name' => 'Spam notification',
                    'Tag' => '',
                    'MessageStream' => 'outbound',
                    'Description' => 'The message was delivered, but was either blocked by the user, or classified as spam, bulk mail, or had rejected content.',
                    'Email' => 'zaphod@example.com',
                    'From' => 'notifications@honeybadger.io',
                    'BouncedAt' => '2023-02-27T21:41:30Z',
                ],
            ],
            [
                'Type', [
                    'RecordType' => 'Bounce',
                    'Type' => 'not_a_valid_type',
                    'TypeCode' => 512,
                    'Name' => 'Spam notification',
                    'Tag' => '',
                    'MessageStream' => 'outbound',
                    'Description' => 'The message was delivered, but was either blocked by the user, or classified as spam, bulk mail, or had rejected content.',
                    'Email' => 'zaphod@example.com',
                    'From' => 'notifications@honeybadger.io',
                    'BouncedAt' => '2023-02-27T21:41:30Z',
                ],
            ],
        ];
    }

    /** @test **/
    public function it_sends_a_slack_message_if_payload_is_a_spam_notification()
    {
        SlackAlert::shouldReceive('message')->once();

        $this->postJson(route('notification'), [
            'RecordType' => 'Bounce',
            'Type' => 'SpamNotification',
            'TypeCode' => 512,
            'Name' => 'Spam notification',
            'Tag' => '',
            'MessageStream' => 'outbound',
            'Description' => 'The message was delivered, but was either blocked by the user, or classified as spam, bulk mail, or had rejected content.',
            'Email' => 'zaphod@example.com',
            'From' => 'notifications@honeybadger.io',
            'BouncedAt' => '2023-02-27T21:41:30Z',
        ]);
    }

    /** @test **/
    public function it_wont_send_a_slack_notification_if_payload_type_is_incorrect()
    {
        SlackAlert::shouldReceive('message')->never();

        $this->postJson(route('notification'), [
            'RecordType' => 'Bounce',
            'MessageStream' => 'outbound',
            'Type' => 'HardBounce',
            'TypeCode' => 1,
            'Name' => 'Hard bounce',
            'Tag' => 'Test',
            'Description' => 'The server was unable to deliver your message (ex: unknown user, mailbox not found).',
            'Email' => 'arthur@example.com',
            'From' => 'notifications@honeybadger.io',
            'BouncedAt' => '2019-11-05T16:33:54.9070259Z',
        ]);
    }

    /**
     * @test
     *
     * @dataProvider validationDataProvider
     */
    public function it_validates_payload(string $field, array $payload)
    {
        $this->postJson(route('notification'), $payload)
            ->assertJsonValidationErrorFor($field);
    }
}
