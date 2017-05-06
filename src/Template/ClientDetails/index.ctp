<?php
/**
  * @var \App\View\AppView $this
  */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>

<div class="clientDetails index large-9 medium-8 columns content">
    <h1 style="text-align: center; text-decoration: underline"><?= __('Client Details') ?></h1>
    <table id="clientDetailsTable" class="table table-striped table-bordered table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Client Name</th>
                <th>Mobile</th>
                <th>Introducer Person</th>
                <th>Client photo</th>
                <th>Client Sign photo</th>
                <th>Status</th>
                <th>Created Date</th>
<!--                <th >--><?php //$this->Paginator->sort('modified_date') ?><!--</th>-->
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; $class = "";
            foreach ($clientDetails as $clientDetail): $count++;
                if($count %2 == 0)
                    $class = "";
                else
                    //$class = "success";

                ?>
            <tr class="<?= $class; ?>">
                <td><?= $this->Number->format($count) ?></td>
                <td><?= h($clientDetail->client_name) ?></td>
                <td><?= $clientDetail->mobile ?></td>
                <td><?= h($clientDetail->introducer_person) ?></td>
                <td><img src="<?= h($clientDetail->client_photo) ?>" width="80" height="80"></td>
                <td><img src="<?= h($clientDetail->client_sign_photo) ?>" width="80" height="80"></td>
                <td><?php
                    echo $status = ($clientDetail->status == 1)? "Active" : "Not active";
                    ?></td>
                <td data-order="<?= h($clientDetail->created_date->nice()) ?>"><?= h($clientDetail->created_date->nice()) ?></td>
<!--                <td>--><?php // h($clientDetail->modified_date) ?><!--</td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientDetail->id],['target' => '_blank']) ?> |
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientDetail->id]) ?> |
                    <?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientDetail->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script>
    $('#clientDetailsTable').DataTable({
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
        /**columnDefs: [
            { type: 'de_datetime', targets: 0 },
            { type: 'de_date', targets: 1 }
        ],**/
//        select: {
//            style:    'os',
//            selector: 'td:first-child'
//        },
//        order: [[ 1, 'asc' ]]
    });

</script>
<script>
    function createBatch(reference) {
        var checkboxes = document.getElementsByClassName('checkbox_check');
        var formSubmit = false;
        var countOfCheckbox = 0;
        var userIdArray = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true)
            {
                countOfCheckbox++;
                formSubmit = true;
                userIdArray.push(checkboxes[i].id);
            }
        }

        if(formSubmit && countOfCheckbox > 1)
        {
                document.getElementById(reference.id).setAttribute("data-target","#myBatchModal");
                document.getElementById('clientIdValues').value = userIdArray;
//            alert(JSON.stringify(userIdArray));   
        }
        else
        {
            alert("Select at least two clients");
        }
    }
</script>
