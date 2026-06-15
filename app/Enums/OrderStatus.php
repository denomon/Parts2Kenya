<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PendingSourcing = 'Pending Sourcing';
    case QuoteSent = 'Quote Sent';
    case AwaitingPayment = 'Awaiting Payment';
    case Paid = 'Paid';
    case ReadyForKenyaShipment = 'Ready for Kenya Shipment';
    case Shipped = 'Shipped';
    case Delivered = 'Delivered';
}
