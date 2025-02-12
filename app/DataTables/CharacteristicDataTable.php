<?php

namespace App\DataTables;

use App\Models\Characteristics;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CharacteristicDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'user.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(characteristics $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([
                'url' => app()->environment('production') ? secure_asset('dist/plugins/datatables/lang/pt-br.json') : asset('dist/plugins/datatables/lang/pt-br.json')
            ])
            ->orderBy(1)
            ->columnDefs([['width' => '100px', 'targets' => 0]])
            ->buttons(
                'excel',
                'csv',
                'pdf',
                'print'
            );
            
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Nome'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'characteristics_' . date('YmdHis');
    }
}
