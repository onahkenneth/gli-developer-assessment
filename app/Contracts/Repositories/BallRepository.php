<?php

namespace App\Contracts\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BallRepository
 * @package namespace App\Repositories;
 */
interface BallRepository extends RepositoryInterface
{
    public function draw();
}
