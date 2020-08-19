<?php

namespace App\Praticien\Code\Worker;

use App\Praticien\Code\Worker\CodeWorkerInterface;
use App\Praticien\Code\Repo\ArretInterface;

class CodeWorker implements CodeWorkerInterface
{
    protected $code;

    public function __construct(ArretInterface $code)
    {
        $this->code = $code;
    }

    public function valid($code)
    {
        return $this->code->valid($code);
    }

    public function markUsed($code_id,$user_id)
    {
        return $this->code->update(['id' => $code_id, 'used' => 1,'user_id' => $user_id]);
    }

    public function active($user_id)
    {
        return $this->code->active($user_id);
    }
}
