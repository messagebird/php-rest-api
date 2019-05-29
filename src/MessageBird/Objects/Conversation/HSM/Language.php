<?php

namespace MessageBird\Objects\Conversation\HSM;

class Language
{
    // Will deliver the message template in the user's device language. If the settings can't be found on the user's
    // device the fallback language is used.
    const FALLBACK_POLICY = 'fallback';

    // Will deliver the message template exactly in the language and locale asked for.
    const DETERMINISTIC_POLICY = 'deterministic';

    /**
     * It accepts FALLBACK_POLICY or DETERMINISTIC_POLICY.
     *
     * @var string $policy
     */
    public $policy;

    /**
     * Code can be both language and language_locale formats (e.g. en and en_US).
     *
     * @var string $code
     */
    public $code;
}
