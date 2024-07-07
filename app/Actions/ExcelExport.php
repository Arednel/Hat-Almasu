<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

use App\Http\Controllers\SupportTicketController;

class ExcelExport extends AbstractAction
{
    public function getTitle()
    {
        return 'Скачать Excel';
    }

    public function getIcon()
    {
        return 'voyager-download';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-primary',
            'style' => 'margin-bottom:8px;' //Fix, so button is at the same spot as other buttons
        ];
    }

    public function getDefaultRoute()
    {
        return route('excel_export');
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'supporttickets';
    }

    public function massAction($ids, $comingFrom)
    {
        return SupportTicketController::excelExport($comingFrom);
    }
}
