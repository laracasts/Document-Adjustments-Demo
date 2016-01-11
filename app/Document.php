<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public static function boot()
    {
        parent::boot();

        static::updating(function($document) {
            $document->adjustments()->attach(Auth::id());
        });
    }

    public function adjustments()
    {
        return $this->belongsToMany(User::class, 'adjustments')
            ->withTimestamps()
            ->latest('pivot_updated_at');

    }
}
