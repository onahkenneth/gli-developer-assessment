<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Ball that represents a lotto draw ball
 *
 * @package App\Entities
 * @property int $id
 * @property int $number
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ball whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ball whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ball whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ball whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ball extends Model implements Transformable
{
    const MAIN_BALL_SET_MINIMUM = 40;
    const MAIN_BALL_SET_MAXIMUM = 49;

    const POWER_BALL_SET_MINIMUM = 5;
    const POWER_BALL_SET_MAXIMUM = 49;

    const MAIN_BALL_DRAW_MINIMUM = 5;
    const MAIN_BALL_DRAW_MAXIMUM = 7;

    const POWER_BALL_DRAW_MINIMUM = 0;
    const POWER_BALL_DRAW_MAXIMUM = 3;

    use TransformableTrait;

    protected $fillable = [];

    /**
     * When the Play button is pressed the correct number of balls are chosen
     * from the ball set and the powerball set, this combination is displayed,
     * showing the balls and powerball(s) if any
     *
     * @return array
     */
    public function draw()
    {
        $mbPicks = $pbPicks = $mbSet = $pbSet = [];

        $mbNumberOfBalls = mt_rand(self::MAIN_BALL_SET_MINIMUM, self::MAIN_BALL_SET_MAXIMUM);
        $pbNumberOfBalls = mt_rand(self::POWER_BALL_SET_MINIMUM, self::POWER_BALL_SET_MAXIMUM);

        $mbNumberOfPicks = mt_rand(self::MAIN_BALL_DRAW_MINIMUM, self::MAIN_BALL_DRAW_MAXIMUM);
        $pbNumberOfPicks = mt_rand(self::POWER_BALL_DRAW_MINIMUM, self::POWER_BALL_DRAW_MAXIMUM);

        for ($i = 0; $i < $mbNumberOfBalls; $i++) {
            $mbSet[] = mt_rand(1, 99);
        }

        for ($i = 0; $i < $pbNumberOfBalls; $i++) {
            $pbSet[] = mt_rand(1, 99);
        }

        for ($i = 0; $i < $mbNumberOfPicks; $i++) {
            $mbPicks[] = $mbSet[$i];
        }

        for ($i = 0; $i < $pbNumberOfPicks; $i++) {
            $pbPicks[] = $pbSet[$i];
        }

        // lotto draw picks.
        return ['main_ball' => $mbPicks, 'power_ball' => $pbPicks, 'time' => \Carbon\Carbon::now()->toDateTimeString()];
    }
}