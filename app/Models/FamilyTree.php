<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyTree extends Model
{
    protected $guarded = ['id'];
    
    // Relationship to get the parent of a person
    public function parent()
    {
        return $this->belongsTo(FamilyTree::class, 'parent_id');
    }

    // Relationship to get the children of a person
    public function children()
    {
        return $this->hasMany(FamilyTree::class, 'parent_id');
    }
}
