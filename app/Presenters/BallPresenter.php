<?php

namespace App\Presenters;

use App\Transformers\BallTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BallPresenter
 *
 * @package namespace App\Presenters;
 */
class BallPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BallTransformer();
    }
}
