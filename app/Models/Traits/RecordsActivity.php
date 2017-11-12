<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 11/12/17
 * Time: 6:08 PM
 */

namespace App\Models\Traits;


use App\Models\Activity;

trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event){
            static::$event(function ($thread) use ($event) {
                $thread->recordActivity($event);
            });
        }
    }

    /**
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * @param $event
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::Class, 'subject');
    }

    /**
     * @param $event
     * @return string
     */
    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}