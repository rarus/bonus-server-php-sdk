<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;

/**
 * Class LevelCollection
 *
 *
 * @method  attach(Level $level, $data = null)
 * @method  Level current()
 *
 * @package Rarus\BonusServer\Card\DTO\Level
 */
class LevelCollection extends \SplObjectStorage
{
    /**
     * получение первого уровня (дефолтного)
     *
     * @return Level
     */
    public function getFirstLevel(): Level
    {
        $this->rewind();
        $minLevelOrder = null;
        $minLevel = null;

        while ($this->valid()) {
            $object = $this->current();
            if ($minLevelOrder === null) {
                $minLevelOrder = $object->getOrder();
            }
            if ($minLevelOrder > $object->getOrder()) {
                $minLevel = $object;
                $minLevelOrder = $object->getOrder();
            }
            $this->next();
        }

        return $minLevel;
    }
}