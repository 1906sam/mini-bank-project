<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>

<div class="batchUser index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Batch User Details') ?></h1>
    <table id="batchUserTable" class="table table-striped table-bordered table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>batch_id</th>
                <th>client_id</th>
                <th>created_date</th>
                <th>modified_date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($batchUser as $batchUser): ?>
            <tr>
                <td><?= $this->Number->format($batchUser->id) ?></td>
                <td><?= $batchUser->has('batch') ? $this->Html->link($batchUser->batch->id, ['controller' => 'Batches', 'action' => 'view', $batchUser->batch->id]) : '' ?></td>
                <td><?= $batchUser->has('client_detail') ? $this->Html->link($batchUser->client_detail->id, ['controller' => 'ClientDetails', 'action' => 'view', $batchUser->client_detail->id]) : '' ?></td>
                <td><?= h($batchUser->created_date) ?></td>
                <td><?= h($batchUser->modified_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $batchUser->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $batchUser->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $batchUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $batchUser->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#batchUserTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
//            'copy',
//            'csv',
            'excel',
            'pdf',
            'print',
            'colvis'
        ],
        responsive: true,
        //keys: true,
        //autoFill: true,
        "pagingType": "first_last_numbers",
        /** columnDefs: [ {
            orderable: false,
            targets:   0,
            render: function(data, type, full, meta) {
                return '<input type="checkbox" id="<?php //echo  $clientDetail->id; ?>" class="checkbox_check">';
            }
        } ], **/
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    });
</script>
