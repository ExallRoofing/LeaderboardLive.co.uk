<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'name',
        'tees',
        'par',
        'sss',
        'holes',
        'yardage',
        'rating',
        'slope_rating',
        'hole_data',
        'is_active',
    ];

    protected $casts = [
        'hole_data' => 'array',
        'is_active' => 'boolean',
        'sss' => 'decimal:1',
        'rating' => 'decimal:1',
    ];

    /**
     * Relationship: a course belongs to a club.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get full hole data array.
     */
    public function getHoleData(): array
    {
        return $this->hole_data ?? [];
    }

    /**
     * Get par for a specific hole number.
     */
    public function getParForHole(int $hole): ?int
    {
        return $this->getHoleAttribute($hole, 'par');
    }

    /**
     * Get stroke index for a specific hole number.
     */
    public function getStrokeIndexForHole(int $hole): ?int
    {
        return $this->getHoleAttribute($hole, 'si');
    }

    /**
     * Get yardage for a specific hole number.
     */
    public function getYardageForHole(int $hole): ?int
    {
        return $this->getHoleAttribute($hole, 'yardage');
    }

    /**
     * Generic helper to pull values from hole_data.
     */
    protected function getHoleAttribute(int $hole, string $attribute): mixed
    {
        $holes = $this->getHoleData();
        foreach ($holes as $data) {
            if ($data['hole'] === $hole && isset($data[$attribute])) {
                return $data[$attribute];
            }
        }
        return null;
    }
}
