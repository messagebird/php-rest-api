<?php

namespace MessageBird\Objects;

/**
 * Class Otp
 *
 * @package MessageBird\Objects
 */
class Otp extends Base
{
    const TYPE_SMS = 'sms';
    const TYPE_TTS = 'tts';
    const TYPE_FLASH = 'flash';

    /**
     * The token to be verified
     *
     * @var string
     */
    public $token;

    /**
     * The recipient
     *
     * @var string
     */
    public $recipient;

    /**
     * A client reference. Here you can put your own reference,
     * like your internal reference.
     *
     * @var string
     */
    public $reference;

    /**
     * The sender of the message. This can be a telephone number
     * (including country code) or an alphanumeric string. In case
     * of an alphanumeric string, the maximum length is 11 characters.
     *
     * @var string
     */
    public $originator;

    /**
     * The type of message. Values can be: sms, tts, or flash
     *
     * @var string
     */
    public $type = self::TYPE_SMS;

    /**
     * The template of the message you'll be sending. Needs to contain at least
     * the following string: '%token'. This is needed to render the token.
     *
     * @var string
     */
    public $template;

    /**
     * The language in which the message needs to be read to the recipient.
     * Possible values are: nl-nl, de-de, en-gb, en-us, fr-fr
     *
     * @var string
     */
    public $language = 'en-gb';

    /**
     * The voice in which the messages needs to be read to the recipient
     * Possible values are: male, female
     *
     * @var string
     */
    public $voice = 'female';

    /**
     * Parses and returns the return object
     *
     * Due to the non-REST implementation, and alternate return object, input
     * that was given should never be returned. The result object returned from
     * the API is, or should, always be correct.
     * @param object The result object
     * @return object Return the result object immediately
     * @author Sam Wierema <sam@messagebird.com>
     */
    public function loadFromArray($object)
    {
        return $object;
    }
}
