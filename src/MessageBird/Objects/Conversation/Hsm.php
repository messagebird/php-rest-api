<?php

namespace MessageBird\Objects\Conversation;

use MessageBird\Objects\Base;

/**
 * A HSM is a pre-approved, reusable message template required when messaging
 * over WhatsApp. It allows you to just send the required parameter values
 * instead of the full message. It also allows for localization of the message
 * and decreases the possibility of being blocked on the first contact as the
 * message is pre-approved by WhatsApp.
 */
class Hsm extends Base
{
    const LANGUAGE_POLICY_DETERMINISTIC = 'deterministic';
    const LANGUAGE_POLICY_FALLBACK = 'fallback';

    /**
     * Namespace where your HSM templates are stored. Can be found in the form
     * for creating new template.
     *
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $templateName;

    /**
     * Language to use for this message.
     * 
     * Using setLanguage() is advised to set this.
     * 
     * @var array
     */
    public $language;

    /**
     * Some of the template parameters related to date/time and currency are
     * localizable and can be displayed based on a customer's device language
     * and local preferences. Default values are used when localization fails.
     * 
     * Using one of the setters in this class is advised to set this.
     * 
     * @var HsmParam[]
     */
    public $params;

    /**
     * @param $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        // Cast stdObject to associative array.
        if (!empty($this->language)) {
            $this->language = (array) $this->language;
        }
        
        if (!empty($this->params)) {
            $hsmParams = array();

            foreach ($this->params as $param) {
                $hsmParam = new HsmParam();
                $hsmParam->loadFromArray($param);

                $hsmParams[] = $hsmParam;
            }

            $this->params = $hsmParams;
        }
     
        return $this;
    }

    /**
     * The code of the language or locale to use, accepts both language and
     * language_locale formats (e.g., en and en_US).
     * 
     * Policy can be either 'deterministic' or 'fallback'. Deterministic will
     * deliver the message template in exactly the language and locale asked
     * for while fallback will deliver the message template in user's device
     * language, if the settings can't be found on users device the fallback
     * language is used.
     * 
     * @param string $code
     * @param string $policy
     */
    public function setLanguage($code, $policy)
    {
        $this->language = array(
            'code' => $code,
            'policy' => $policy,
        ); 
    }

    /**
     * Adds a HSM param to this message.
     * 
     * @param HsmParam $param
     */
    public function addParam($param)
    {
        $this->params[] = $param;
    }

    /**
     * Convenient way to get a Content object with this HSM set.
     * 
     * @return Content
     */
    public function toContent()
    {
        $content = new Content();
        $content->hsm = $this;

        return $content;
    }
}
