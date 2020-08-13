<?php

namespace mipotech\doxi\requests;

class AddSignFlow extends BaseRequest
{
    /**
     * @var string
     */
    public $documentFileName;
    /**
     * @var string
     */
    public $senderUserName;
    /**
     * @var string
     */
    public $description;
    /**
     * @var array each element should be in the following format:
     *
     * - userEmail (string)
     * - elementType (int)
     * - elementSubType (int)
     * - pageNumber (int)
     * - position (array)
     *     - top (int)
     *     - left (int)
     *     - width (int)
     *     - height (int)
     * - isEditorElement (bool)
     * - textSize (int)
     * - isRequired (bool)
     * - validations (array)
     * - dropDownList (array)
     * - additionalInfo (array)
     */
    public $flowElements;
    /**
     * @var int
     */
    public $sendMethodType;
    /**
     * @var bool
     */
    public $isSendApprovalMailToAllSigners;
    /**
     * @var bool
     */
    public $isAutomaticRemainder;
    /**
     * @var int
     */
    public $dayesForAutomaticRemainder;
    /**
     * @var array
     *
     * Each element must be in the following format:
     * - key (string)
     * - value (mixed)
     */
    public $customFields;
    /**
     * @var array
     *
     * Format for the elements of this array:
     * - email (string)
     * - firstName (string)
     * - lastName (string)
     * - smsPhoneNumber (string)
     * - userPassword (string)
     * - isDisableAttachment (boolean)
     */
    public $users;
    /**
     * @var string
     */
    public $packageId;
    /**
     * @var string
     */
    public $packageName;
    /**
     * @var bool
     */
    public $isNoSend;
    /**
     * @var string
     */
    public $preliminaryText;
    /**
     * @var string
     */
    public $base64DocumentFile;

    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'AddSignFlow';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
