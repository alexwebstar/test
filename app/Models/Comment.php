<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use NodeTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['_lft',	'_rgt',	'parent_id', 'name', 'comment', 'created_at', 'updated_at'];
}
