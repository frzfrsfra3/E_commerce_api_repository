<?php


namespace App\Responders;

use Illuminate\Http\JsonResponse;

class JsonResponder
{
    protected $data = [];
    protected $status = 200;

    public function withData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function withStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    public function respond()
    {
        return new JsonResponse($this->data, $this->status);
    }
}
