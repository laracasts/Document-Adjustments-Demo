<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Boot the model.
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function($document) {
            $document->adjust();
        });
    }
    
    /**
     * Fetch all user adjustments for the document.
     */
    public function adjustments()
    {
        return $this->belongsToMany(User::class, 'adjustments')
            ->withTimestamps()
            ->withPivot(['before', 'after'])
            ->latest('pivot_updated_at');
    }
    
    /**
     * Record an adjustment to the document.
     *
     * @param integer|null $userId
     * @param array|null   $diff
     */
    public function adjust($userId = null, $diff = null)
    {
        return $this->adjustments()->attach(
            $userId ?: Auth::id(),
            $diff ?: $this->getDiff() 
        );
    }
    
    /**
     * Fetch a diff for the model's current state.
     */
    protected function getDiff()
    {
        $changed = $this->getDirty();

        $before = json_encode(array_intersect_key($this->fresh()->toArray(), $changed));
        $after  = json_encode($changed);

        return compact('before', 'after');
    }
}

