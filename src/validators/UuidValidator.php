<?php

namespace eluhr\uuidAttributeBehavior\validators;

use Ramsey\Uuid\Validator\GenericValidator;
use Yii;
use yii\validators\Validator;

class UuidValidator extends Validator
{
    public function init()
    {
        parent::init();
        if (empty($this->message)) {
            $this->message = Yii::t('uuid-attribute-validator', '{attribute} is not a valid UUID.');
        }
    }

    /**
     * @inheritdoc
     */
    public function validateValue($value)
    {
        $validator = new GenericValidator();
        if ($validator->validate($value)) {
            return null;
        }
        return [$this->message, []];
    }
}
