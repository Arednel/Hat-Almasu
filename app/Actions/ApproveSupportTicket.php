<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ApproveSupportTicket extends AbstractAction
{
    public function getTitle()
    {
        return 'Одобрить заявку';
    }

    public function getIcon()
    {
        return 'voyager-check';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
            'style' => 'margin-right:5px;'
        ];
    }

    public function getDefaultRoute()
    {
        return route('approve_support_ticket', ['support_ticket_id' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return ($this->dataType->slug == 'supporttickets') || ($this->dataType->slug == 'other');
    }

    public function shouldActionDisplayOnRow($row)
    {
        return ($row->supportTicketStatus == 'На рассмотрении') || ($row->supportTicketStatus == 'Отклонена');
    }
}
