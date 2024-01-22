<?php declare(strict_types=1);

use eluhr\uuidAttributeBehavior\behaviors\UuidAttributeBehavior;
use PHPUnit\Framework\TestCase;
use yii\base\Model;

final class UuidAttributeBehaviorTest extends TestCase
{
    public function testValidateAttributeNotEmpty(): void
    {
        $item = new Item();
        $item->generateUuid();
        $this->assertIsString($item->uuid);
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

    // Mock active record methods
    public function getIsNewRecord()
    {
        return true;
    }

    public function hasAttribute($name)
    {
        return true;
    }

    public function getAttribute($name)
    {
        return $this->getAttributes($name)[$name] ?? null;
    }

    public function setAttribute($name, $value)
    {
        $this->setAttributes([$name => $value]);
    }
}

