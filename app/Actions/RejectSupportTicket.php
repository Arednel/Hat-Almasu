<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class RejectSupportTicket extends AbstractAction
{
    public function getTitle()
    {
        return 'Отклонить заявку';
    }

    public function getIcon()
    {
        return 'voyager-x';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-danger pull-right',
            'style' => 'margin-right:5px;'
        ];
    }

    public function getDefaultRoute()
    {
        return route('reject_support_ticket', ['support_ticket_id' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return ($this->dataType->slug == 'supporttickets') || ($this->dataType->slug == 'other');
    }

    public function shouldActionDisplayOnRow($row)
    {
        return ($row->supportTicketStatus == 'На рассмотрении') || ($row->supportTicketStatus == 'Одобрена');
    }
}
