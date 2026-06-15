<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case Draft = 'Draft';
    case Sent = 'Sent';
    case Accepted = 'Accepted';
    case Rejected = 'Rejected';
    case Expired = 'Expired';
}
