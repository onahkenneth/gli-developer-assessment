<?php

namespace App\Http\Controllers;

use League\Csv\Writer;
use App\Entities\Ball;

class BallsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lottoDraw()
    {
        $balls = (new Ball())->draw();

        $this->storeDrawRecords($balls);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $balls,
            ]);
        }

        return view('balls.index', compact('balls'));
    }

    protected function storeDrawRecords($data)
    {
        $fileName = 'downloads/draw.csv';

        if(!file_exists(public_path($fileName))) {
            $header = ['main_ball', 'power_ball', 'time'];

            $writer = Writer::createFromPath(public_path($fileName), 'a+');
            $writer->insertOne($header);
        } else {
            $writer = Writer::createFromPath(public_path($fileName), 'a+');
        }

        if(!empty($data['main_ball']))
            $data['main_ball'] = implode(" ", $data['main_ball']);
        else
            $data['main_ball'] = '';

        if(!empty($data['power_ball']))
            $data['power_ball'] = implode(" ", $data['power_ball']);
        else
            $data['power_ball'] = '';


        $writer->insertOne([$data['main_ball'], $data['power_ball'], $data['time']]);
    }

    /**
     * Download sample CSV
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadCSV()
    {
        $file = public_path() . "/downloads/draw.csv";

        $headers = [
            'content-type'              => 'text/cvs',
            'Content-Disposition'       => 'attachment; filename="export.csv"',
            'Cache-control'             => 'private, must-revalidate, post-check=0, pre-check=0',
            'Content-transfer-encoding' => 'binary',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        return Response()->download($file, 'lotto-draw.csv', $headers);
    }
}
