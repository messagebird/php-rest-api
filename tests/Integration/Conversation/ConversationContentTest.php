<?php

namespace Tests\Integration\Conversation;

use MessageBird\Objects\Conversation\Content;
use MessageBird\Objects\Conversation\Message;
use Tests\Integration\BaseTest;

/**
 * Tests the static factories in Content.
 */
class ConversationContentTest extends BaseTest
{
    public function testAudioContent(): void
    {
        $content = new Content();
        $content->audio = ['url' => 'https://example.com/audio.mp3'];

        $message = new Message();
        $message->content = $content;
        $message->type = 'audio';

        self::assertEquals($message, $this->messageFromJson(
            '{"type":"audio","content":{"audio":{"url":"https://example.com/audio.mp3"}}}'
        ));
    }

    private function messageFromJson(string $json): Message
    {
        $message = new Message();
        $message->loadFromArray(
            json_decode($json)
        );

        return $message;
    }

    public function testFileContent(): void
    {
        $content = new Content();
        $content->file = ['url' => 'https://example.com/file.pdf'];

        $message = new Message();
        $message->content = $content;
        $message->type = 'file';

        self::assertEquals($message, $this->messageFromJson(
            '{"type":"file","content":{"file":{"url":"https://example.com/file.pdf"}}}'
        ));
    }

    public function testImageContent(): void
    {
        $content = new Content();
        $content->image = ['url' => 'https://example.com/image.png'];

        $message = new Message();
        $message->content = $content;
        $message->type = 'image';

        self::assertEquals($message, $this->messageFromJson(
            '{"type":"image","content":{"image":{"url":"https://example.com/image.png"}}}'
        ));
    }

    public function testLocationContent(): void
    {
        $content = new Content();
        $content->location = [
            'latitude' => '37.778326',
            'longitude' => '-122.394648',
        ];

        $message = new Message();
        $message->content = $content;
        $message->type = 'location';

        self::assertEquals($message, $this->messageFromJson(
            '{"type":"location","content":{"location":{"latitude":"37.778326","longitude":"-122.394648"}}}'
        ));
    }

    public function testTextContent(): void
    {
        $content = new Content();
        $content->text = 'Foo Bar';

        $message = new Message();
        $message->content = $content;
        $message->type = 'text';

        self::assertEquals($message, $this->messageFromJson(
            '{"type":"text","content":{"text":"Foo Bar"}}'
        ));
    }

    public function testVideoContent(): void
    {
        $content = new Content();
        $content->video = ['url' => 'https://example.com/video.mp4'];

        $message = new Message();
        $message->content = $content;
        $message->type = 'video';

        self::assertEquals($message, $this->messageFromJson(
            '{"type":"video","content":{"video":{"url":"https://example.com/video.mp4"}}}'
        ));
    }
}
