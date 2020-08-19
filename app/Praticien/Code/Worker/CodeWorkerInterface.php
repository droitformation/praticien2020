<?php

namespace App\Praticien\Code\Worker;

interface CodeWorkerInterface
{
    public function valid($code);
    public function markUsed($code_id,$user_id);
}
