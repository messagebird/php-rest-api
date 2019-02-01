<?php

use MessageBird\Objects\Conversation\Content;
use MessageBird\Objects\Conversation\Message;

/**
 * Tests the static factories in Content.
 */
class ConversationContentTest extends BaseTest
{
    /**
     * @param string $json
     * 
     * @return Message
     */
    private function messageFromJson($json)
    {
        $message = new Message();
        $message->loadFromArray(
            json_decode($json)
        );

        return $message;
    }

    public function testAudioContent()
    {
        $content = new Content();
        $content->audio = array('url' => 'https://example.com/audio.mp3');

        $message = new Message();
        $message->content = $content;
        $message->type = 'audio';

        $this->assertEquals($message, $this->messageFromJson(
            '{"type":"audio","content":{"audio":{"url":"https://example.com/audio.mp3"}}}'
        ));
    }

    public function testFileContent()
    {
        $content = new Content();
        $content->file = array('url' => 'https://example.com/file.pdf');

        $message = new Message();
        $message->content = $content;
        $message->type = 'file';

        $this->assertEquals($message, $this->messageFromJson(
            '{"type":"file","content":{"file":{"url":"https://example.com/file.pdf"}}}'   
        ));
    }

    public function testImageContent()
    {
        $content = new Content();
        $content->image = array('url' => 'https://example.com/image.png');

        $message = new Message();
        $message->content = $content;
        $message->type = 'image';

        $this->assertEquals($message, $this->messageFromJson(
            '{"type":"image","content":{"image":{"url":"https://example.com/image.png"}}}'
        ));
    }

    public function testLocationContent()
    {
        $content = new Content();
        $content->location = array(
            'latitude' => '37.778326',
            'longitude' => '-122.394648',
        );

        $message = new Message();
        $message->content = $content;
        $message->type = 'location';

        $this->assertEquals($message, $this->messageFromJson(
            '{"type":"location","content":{"location":{"latitude":"37.778326","longitude":"-122.394648"}}}'
        ));
    }

    public function testTextContent()
    {
        $content = new Content();
        $content->text = 'Foo Bar';

        $message = new Message();
        $message->content = $content;
        $message->type = 'text';

        $this->assertEquals($message, $this->messageFromJson(
            '{"type":"text","content":{"text":"Foo Bar"}}'
        ));
    }

    public function testVideoContent()
    {
        $content = new Content();
        $content->video = array('url' => 'https://example.com/video.mp4');

        $message = new Message();
        $message->content = $content;
        $message->type = 'video';

        $this->assertEquals($message, $this->messageFromJson(
            '{"type":"video","content":{"video":{"url":"https://example.com/video.mp4"}}}'
        ));
    }
}
