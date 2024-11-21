<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Models;

use App\Infrastructure\Laravel\Database\Factories\AgencyModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgencyModel extends Model
{
    /** @use HasFactory<AgencyModelFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:m:s',
        'updated_at' => 'date:Y-m-d H:m:s',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return AgencyModelFactory::new();
    }

    public function spies(): HasMany
    {
        return $this->hasMany(SpyModel::class, 'agency_id');
    }
}
