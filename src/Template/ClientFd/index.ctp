<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="clientFd index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Client\'s FD') ?></h1>
    <table id="clientFdTable" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Client Information</th>
                <th>FD Amount</th>
                <th>Time Duration</th>
                <th>Rate Of Interest</th>
                <th>Terminating Amount</th>
                <th>Status</th>
                <th>Created Date</th>
<!--                <th>Modified Date</th>-->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
                foreach ($clientFd as $clientFd):
                    $count++;
                    if($count %2 == 0)
                        $class = "";
                    else
                        //$class = "success";
            ?>
                    <tr>
                <td><?= $this->Number->format($count) ?></td>
                <td>
                    <img src="<?= h($clientFd->client_detail->client_photo) ?>" width="80" height="80"><br>
                    <?= $clientFd->has('client_detail') ? $this->Html->link($clientFd->client_detail->client_name, ['controller' => 'ClientDetails', 'action' => 'view', $clientFd->client_detail->id],['target' => '_blank']) : '' ?>
                </td>
                <td><?= $this->Number->currency($clientFd->fd_amount) ?></td>
                <td><?= $this->Number->format($clientFd->time_duration) ?></td>
                <td><?= $this->Number->toPercentage($clientFd->rate_of_interest) ?></td>
                <td><?= $this->Number->currency($clientFd->terminating_amount) ?></td>
                <td><?= $status = ($clientFd->status == 0) ? 'Running' : 'Complete'; ?></td>
                <td><?= h($clientFd->created_date->format("d-M-Y")) ?></td>
<!--                <td>--><?php // h($clientFd->modified_date) ?><!--</td>-->
                <td class="actions">
<!--                    --><?php //echo $this->Html->link(__('View'), ['action' => 'view', $clientFd->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientFd->id]) ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientFd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientFd->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $.fn.dataTable.moment('D-MMM-YYYY');
        $('#clientFdTable').DataTable({
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
            "pagingType": "first_last_numbers"
//        columnDefs: [ {
//            orderable: false,
//            className: 'select-checkbox',
//            targets:   0
//        } ],
//        select: {
//            style:    'os',
//            selector: 'td:first-child'
//        },
//        order: [[ 1, 'asc' ]]
        });
    });
</script>
