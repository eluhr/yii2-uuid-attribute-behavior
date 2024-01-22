<?php declare(strict_types=1);

use eluhr\uuidAttributeBehavior\behaviors\UuidAttributeBehavior;
use PHPUnit\Framework\TestCase;
use yii\base\Model;

final class JsonAttributeBehaviorTest extends TestCase
{
    public function testValidateAttributeNotEmpty(): void
    {
        $this->assertIsString((new Item(['data_json' => '{"a": "b"}']))->uuid);
    }
}

class Item extends Model
{
    /**
     * @var string|null
     */
    public ?string $uuid = null;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['uuid-attribute'] = [
            'class' => UuidAttributeBehavior::class
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [['uuid'], 'required'];
        return $rules;
    }
}

