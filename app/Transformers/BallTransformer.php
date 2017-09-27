<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Ball;

/**
 * Class BallTransformer
 * @package namespace App\Transformers;
 */
class BallTransformer extends TransformerAbstract
{

    /**
     * Transform the \Ball entity
     * @param Ball $model
     *
     * @return array
     */
    public function transform(Ball $model)
    {
        return [
            'id'         => (int) $model->id,
            'number'     => (int) $model->number,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
