<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Models;

use App\Infrastructure\Laravel\Database\Factories\SpyModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpyModel extends Model
{
    /** @use HasFactory<SpyModelFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'agency',
        'country_of_operation',
        'date_of_birth',
        'date_of_death',
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
        'date_of_death' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d H:m:s',
        'updated_at' => 'date:Y-m-d H:m:s',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return SpyModelFactory::new();
    }
}
