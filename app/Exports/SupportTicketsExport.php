<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SupportTicketsExport implements FromArray, ShouldAutoSize
{
    protected $supportTickets;

    public function __construct(array $supportTickets)
    {
        $this->supportTickets = $supportTickets;
    }

    public function array(): array
    {
        return $this->supportTickets;
    }
}
