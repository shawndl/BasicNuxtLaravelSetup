<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 28/4/18
 * Time: 3:43 PM
 */

namespace App\Traits\Models;


use App\Feedback;
use App\User;
use Illuminate\Database\Eloquent\Model;

trait HasFeedbackTrait
{
    /**
     * the model can have feedback
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function feedback()
    {
        return $this->morphMany(Feedback::class, 'feedback');
    }

    /**
     * adds feedback to the model
     *
     * @param User $user
     * @param int $review
     * @param string $comment
     * @return Model
     */
    public function review(User $user, int $review, string $comment)
    {
        return $this->feedback()->create([
            'user_id' => $user->id,
            'review' => $review,
            'comment' => $comment
        ]);
    }
}