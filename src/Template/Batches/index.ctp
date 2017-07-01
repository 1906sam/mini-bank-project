<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="batches index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Batch Details') ?></h1>
    <table id="batchTable" class="table table-striped table-bordered table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Batch Name</th>
                <th>Total Members</th>
                <th>Total RD</th>
                <th>Total Loan</th>
                <th>Total FD</th>
                <th>Status</th>
                <th>Created Date</th>
<!--                <th>Modified Date</th>-->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
                foreach ($batches as $batch): $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";
            ?>
            <tr>
                <td><?= $count ?></td>
                <td><?= $this->Html->link($batch->batch_name, ['controller' => 'Batches', 'action' => 'view', $batch->id],['target' => '_blank']) ?></td>
                <td><?= $batchClientData[$batch->id] ?></td>
                <td><?= $this->Number->currency($batchRdData[$batch->id]); ?></td>
                <td><?= $this->Number->currency($batchLoanData[$batch->id]); ?></td>
                <td><?= $this->Number->currency($batchFdData[$batch->id]); ?></td>
                <td><?= $status = ($batch->status == 0) ? 'Not Active' : 'Active'; ?></td>
                <td><?= h($batch->created_date->format("d-M-Y")) ?></td>
<!--                <td>--><?php ////echo h($batch->modified_date) ?><!--</td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $batch->id],['target' => '_blank']) ?> |
                    <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $batch->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $batch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $batch->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $.fn.dataTable.moment('D-MMM-YYYY');
        $('#batchTable').DataTable({
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
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]
        });
    });
</script>
