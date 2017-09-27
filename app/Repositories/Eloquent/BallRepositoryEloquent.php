<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\BallRepository;
use App\Entities\Ball;
use App\Validators\BallValidator;

/**
 * Class BallRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BallRepositoryEloquent extends BaseRepository implements BallRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ball::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return BallValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function draw()
    {
        (new $this->model())->draw();
    }
}
