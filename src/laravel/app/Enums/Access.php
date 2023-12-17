<?php

namespace App\Enums;


enum Access: string
{
    case Read = 'read';
    case Write = 'write';
    case Grant = 'grant';
}