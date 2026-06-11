<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\IdeaStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'links',
        'image_path',
    ];

    protected $casts = [
        'links' => AsArrayObject::class,
        'status' => IdeaStatus::class,
    ];

    protected $attributes = [
        'status' => IdeaStatus::PENDING->value,
    ];

    public static function statusCounts (User $user): Collection
    {
        $counts = $user->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return collect(IdeaStatus::cases())
            ->mapWithKeys(fn ($status) => [
                $status->value => $counts->get($status->value, 0) 
            ])
            ->put('all', Auth::user()->ideas()->count());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

}
