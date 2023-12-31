<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = [
        'url',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute(): string
    {
        // return route("questions.show", $this->id);
        return '#';
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function posts(): array
    {
        $type = request()->get('type');

        if ($type === 'questions') {
            $posts = $this->questions()->get();
        }
        else {
            $posts = $this->answers()->with('question')->get();

            if ($type !== 'answers') {
                $posts2 = $this->questions()->get();

                $posts = $posts->merge($posts2);
            }
        }

        $data = collect();

        foreach ($posts as $post)
        {
            $item = [
                'votes_count' => $post->votes_count,
                'created_at' => $post->created_at->format('d-m-Y'),
            ];

            if ($post instanceof Answer)
            {
                $item['type'] = 'A';
                $item['title'] = $post->question->title;
                $item['accepted'] = $post->question->best_answer_id === $post->id ? true : false;
            }

            elseif ($post instanceof Question)
            {
                $item['type'] = 'Q';
                $item['title'] = $post->title;
                $item['accepted'] = (bool) $post->best_answer_id;
            }

            $data->push($item);
        }

        return $data->sortByDesc('votes_count')->values()->all();
    }

    public function getAvatarAttribute(): string
    {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favorites(): BelongsToMany
    {
           return $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id')->withTimestamps();
    }

    public function voteQuestions(): MorphToMany
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers(): MorphToMany
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote): int
    {
        $voteQuestions = $this->voteQuestions();

        return $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote): int
    {
        $voteAnswers = $this->voteAnswers();

        return $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote): int
    {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        }
        else {
            $relationship->attach($model, ['vote' => $vote]);
        }

        $model->load('votes');
        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upVotes + $downVotes;
        $model->save();
        return $model->votes_count;
    }
}
