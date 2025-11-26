<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;

class GamificationService
{
    public function addPoints(User $user, int $amount, string $reason)
    {
        $user->increment('points', $amount);
        $this->checkBadges($user);

        // In a real app, we would broadcast an event here
        // broadcast(new PointsAwarded($user, $amount, $reason));
    }

    public function checkBadges(User $user)
    {
        $badges = Badge::all();
        $userBadges = $user->badges->pluck('id')->toArray();

        foreach ($badges as $badge) {
            if (in_array($badge->id, $userBadges)) {
                continue;
            }

            $awarded = false;

            switch ($badge->type) {
                case 'chat':
                    // Assuming we track message count somewhere, or just check points as proxy
                    // For now, let's use points as a simplified proxy for activity if specific counts aren't tracked
                    // Ideally: $user->messages()->count() >= $badge->threshold
                    if ($user->points >= $badge->threshold * 1) { // 1 point per msg
                        $awarded = true;
                    }
                    break;
                case 'spend':
                    // Check total spend
                    // $totalSpend = $user->orders()->sum('total');
                    // if ($totalSpend >= $badge->threshold) $awarded = true;
                    break;
                case 'win':
                    // Check auction wins
                    break;
                case 'register':
                    $awarded = true; // Always award on first check
                    break;
            }

            if ($awarded) {
                $user->badges()->attach($badge->id);
                // broadcast(new BadgeUnlocked($user, $badge));
            }
        }
    }
}
