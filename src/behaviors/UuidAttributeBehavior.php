<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2020 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace eluhr\uuidAttributeBehavior\behaviors;

use Ramsey\Uuid\Uuid;
use yii\base\InvalidConfigException;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * UUID behavior for active record models
 *
 * To use UuidBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use project\components\behaviors\UuidBehavior;
 *
 * public function behaviors()
 * {
 *      $behaviors = parent::behaviors();
 *      $behaviors['uuid'] = [
 *          'class' => UuidBehavior::class
 *      ];
 *      return $behaviors;
 * }
 * ```
 *
 * --- PUBLIC PROPERTIES ---
 *
 * @property string $uuidAttribute
 * @property null|callable $value
 *
 * --- PROTECTED READONLY PROPERTIES ---
 *
 * @property-read string $uuidValue
 *
 * --- INHERITED READONLY PROPERTIES ---
 *
 * @property-read ActiveRecord $owner
 *
 * @author Elias Luhr <e.luhr@herzogkommunikation.de>
 */
class UuidAttributeBehavior extends AttributeBehavior
{

    /**
     * @var string the attribute that will receive the uuid value.
     */
    public $uuidAttribute = 'uuid';

    /**
     * @var callable in case, when the value is `null`, the result callable will be used as value.
     *
     * ```php
     * [
     *     'value' => function (yii\db\ActiveRecord $model) {
     *         // return uuid
     *     },
     * ],
     * ```
     */
    public $value;

    /**
     * List of events used in this behavior
     *
     * @return array
     */
    public function events(): array
    {
        $events = parent::events();
        $events[BaseActiveRecord::EVENT_BEFORE_INSERT] = 'generateUuid';
        $events[BaseActiveRecord::EVENT_INIT] = 'generateUuid';
        return $events;
    }

    /**
     * Get a new uuid
     *
     * @throws InvalidConfigException
     * @return string
     */
    protected function getUuidValue(): string
    {
        if (empty($this->value)) {
            return Uuid::uuid4()->toString();
        }
        return call_user_func($this->value, $this->owner);
    }

    /**
     * Generate and set an uuid for the defined owner attribute
     *
     * @throws InvalidConfigException
     * @return void
     */
    public function generateUuid(): void
    {
        $owner = $this->owner;

        // Check if is new record, attribute exists in model and is empty (not predefined by user)
        if ($owner->getIsNewRecord() && $owner->hasAttribute($this->uuidAttribute) && empty($owner->getAttribute($this->uuidAttribute))) {
            $owner->setAttribute($this->uuidAttribute, $this->getUuidValue());
        }
    }
}
