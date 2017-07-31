<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="clientDetails view large-9 medium-8 columns content">
    <div class="row">
        <div class="col-md-4">
            <div class="tableimg">
                <img src="<?= h($clientDetail->client_photo) ?>" style="width: 158px; height: 200px;"><br>
            </div>
            <p id="clientName"><?= h($clientDetail->client_name) ?></p>
        </div>
        <div class="tableui col-md-6" align="center">
            <table class="table table-responsive table-striped">
                <tbody>
                <caption >Personal Details</caption>
                <tr>
                    <th class="col-lg-3" scope="row"><?= __('Id') ?></th>
                    <td class="col-lg-3"><?= $this->Number->format($clientDetail->id) ?></td>
                </tr>
<!--                <tr>-->
<!--                    <th scope="row">--><?php // __('Client Name') ?><!--</th>-->
<!--                    <td>--><?php // h($clientDetail->client_name) ?><!--</td>-->
<!--                </tr>-->
                <tr>
                    <th scope="row"><?= __('Introducer Person') ?></th>
                    <td><?= h($clientDetail->introducer_person) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Mobile') ?></th>
                    <td><?= $clientDetail->mobile ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Address') ?></th>
                    <td><?= trim(h($clientDetail->client_address)); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Status') ?></th>
                    <td><?= $status = ($clientDetail->status == 1)? "Active" : "Not active"; ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Client Sign Photo') ?></th>
                    <td><img src="<?= h($clientDetail->client_sign_photo) ?>" width="80" height="40"></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Client Created Date') ?></th>
                    <td><?= $clientDetail->created_date->nice(); ?></td>
                </tr>
<!--                <tr>-->
<!--                     <th scope="row">--><?php //__('Modified Date') ?><!--</th>-->
<!--                     <td>--><?php //h($clientDetail->modified_date) ?><!--</td>-->
<!--                </tr>-->
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <!-- for left side table -->
        <?php if(!empty($clientRdData)) { ?>
            <h3 style="text-align: center;">************************RD Section***************************</h3>
        <div class="tablemarg tableui col-md-12">
            <table class="table table-responsive table-striped">
                <caption>RD Details</caption>
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('RD Amount') ?></th>
                    <th scope="col"><?= __('Rate of Interest') ?></th>
                    <th scope="col"><?= __('Time Duration') ?></th>
                    <th scope="col"><?= __('Status') ?></th>
                    <?php
                        if(!empty($finalRdAmount)) {
                    ?>
                    <th scope="col"><?= __('Total Interest') ?></th>
                    <th scope="col"><?= __('Penalty') ?></th>
                    <th scope="col"><?= __('Terminating Amount') ?></th>
                    <?php } ?>
                    <th scope="col"><?= __('RD Closing Date') ?></th>
                    <th scope="col"><?= __('RD Created Date') ?></th>
<!--                    <th scope="col" class="actions">--><? // echo __('Actions') ?><!--</th>-->
                </tr>
                <?php foreach ($clientRdData as $clientRd): ?>
                    <tr>
                        <td><?= $this->Number->format($clientRd['id']) ?></td>
                        <td><?= $this->Number->currency($clientRd['rd_amount']) ?></td>
                        <td><?= $this->Number->toPercentage($clientRd['rate_of_interest']) ?></td>
                        <td><?= h($clientRd['time_duration'])." years" ?></td>
                        <td><?php
                            if($clientRd['status'] == 0)
                                echo 'Running';
                            else
                                echo 'Closed';
                            ?>
                        </td>
                        <td><?= $this->Number->currency($totalInterest[$clientRd['id']]); ?></td>
                        <td><?= $this->Number->currency($totalPenalty[$clientRd['id']]); ?></td>
                        <td><?= $this->Number->currency($finalRdAmount[$clientRd['id']][0]['final_rd_amount']); ?></td>
                        <td><?php  if($clientRd['status'] == 1) { ?>
                                <?= $clientRd['modified_date']->nice(); ?>
                            <?php }
                            else
                            {
                                echo "NA";
                            }
                            ?></td>
                        <td><?= $clientRd['created_date']->nice(); ?></td>
<!--                        <td class="actions">-->
                            <?php //echo $this->Html->link(__('View'), ['controller' => 'ClientRdPayments', 'action' => 'view', $clientRdPayments->id]) ?>
                            <?php //echo  $this->Html->link(__('Edit'), ['controller' => 'ClientRdPayments', 'action' => 'edit', $clientRdPayments->id]) ?>
                            <?php //echo  $this->Form->postLink(__('Delete'), ['controller' => 'ClientRdPayments', 'action' => 'delete', $clientRdPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayments->id)]) ?>
<!--                        </td>-->
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php if(!empty($clientFdData)) { ?>
            <h3 style="text-align: center;">************************FD Section***************************</h3>
            <div class="tablemarg tableui center col-md-12" >
                <table class="table table-responsive table-striped">
                    <tbody>
                    <caption>FD Details</caption>

                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Amount Invested') ?></th>
                        <th scope="col"><?= __('Rate of Interest') ?></th>
                        <th scope="col"><?= __('Time Duration') ?></th>
                        <th scope="col"><?= __('Status') ?></th>
                        <th scope="col"><?= __('Terminating Amount') ?></th>
                        <th scope="col"><?= __('FD Created Date') ?></th>
                        <th scope="row"><?= __('FD Closing Date') ?></th>
                    </tr>
                    <?php foreach ($clientFdData as $clientFd): ?>
                        <tr>
                            <td><?= $this->Number->format($clientFd['id']) ?></td>
                            <td><?= $this->Number->currency($clientFd['fd_amount']) ?></td>
                            <td><?= $this->Number->toPercentage($clientFd['rate_of_interest'],3) ?></td>
                            <td><?= h($clientFd['time_duration'])." years" ?></td>
                            <td><?php
                                if($clientFd['status'] == 0)
                                    echo 'Running';
                                else
                                    echo 'Closed';
                                ?>
                            </td>
                            <td>
                                <?php  if($clientFd['status'] == 0)
                                {
                                    $today = date_create(date("Y-m-d H:i:s"));
                                    $dateDiff = date_diff($today, $clientFd['created_date']);
                                    $duration = floor(($dateDiff->y * 12 + $dateDiff->m) / 3);
                                    $finalFdAmount = $clientFd['fd_amount'] * pow((1 + ($clientFd['rate_of_interest'] / 400)), $duration);
                                    echo $this->Number->currency($finalFdAmount);
                                }
                                else
                                {
                                    $dateDiff = date_diff($clientFd['modified_date'], $clientFd['created_date']);
                                    $duration = floor(($dateDiff->y * 12 + $dateDiff->m) / 3);

                                    $finalFdAmount = $clientFd['fd_amount'] * pow((1 + ($clientFd['rate_of_interest'] / 400)), $duration);
                                    echo $this->Number->currency($finalFdAmount);
                                }
                                ?>
                            </td>
                            <td><?= $clientFd['created_date']->nice(); ?></td>
                            <td><?php  if($clientFd['status'] == 1) { ?>
                                    <?= $clientFd['modified_date']->nice(); ?>
                                <?php }
                                else
                                {
                                    echo "NA";
                                }
                                ?></td>
                            <!--                        <td class="actions">-->
                            <?php //echo $this->Html->link(__('View'), ['controller' => 'ClientRdPayments', 'action' => 'view', $clientRdPayments->id]) ?>
                            <?php //echo  $this->Html->link(__('Edit'), ['controller' => 'ClientRdPayments', 'action' => 'edit', $clientRdPayments->id]) ?>
                            <?php //echo  $this->Form->postLink(__('Delete'), ['controller' => 'ClientRdPayments', 'action' => 'delete', $clientRdPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientRdPayments->id)]) ?>
                            <!--                        </td>-->
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php if(!empty($clientLoanData)) { ?>
            <h3 style="text-align: center;">************************Loan Section***************************</h3>
            <div class="tablemarg tableui col-md-5" >
                <table class="table table-responsive table-striped">
                    <tbody>
                    <caption>Loan Details</caption>
                    <tr>
                        <th class="col-lg-3" scope="row"><?= __('Id') ?></th>
                        <td class="col-lg-3"><?php echo $this->Number->format($clientLoanData[0]['id']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-lg-3" scope="row"><?= __('Loan Amount') ?></th>
                        <td class="col-lg-3"><?php echo $this->Number->currency($clientLoanData[0]['loan_amount']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Rate of Interest') ?></th>
                        <td><?= $this->Number->toPercentage($clientLoanData[0]['rate_of_interest']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?php echo $status = ($clientLoanData[0]['status'] == 0) ? 'Running' : 'Closed'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created Date') ?></th>
                        <td><?= $clientLoanData[0]['created_date']->nice(); ?></td>
                    </tr>
                    <?php  if($clientLoanData[0]['status'] == 1) { ?>
                        <tr>
                            <th scope="row"><?= __('Closing Date') ?></th>
                            <td><?= $clientLoanData[0]['modified_date']->nice(); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <!-- for right side table -->
        <?php if(!empty($clientLoanPaymentData)) { ?>
            <div class="tablemarg tableui col-md-5" >
                <table class="table table-responsive table-striped">
                    <tbody>
                    <caption>Important Information</caption>
                    <tr>
                        <th scope="row"><?= __('Principal Left') ?></th>
                        <td>
                            <?php
                            $arraySize = sizeof($clientLoanPaymentData);
                            echo $this->Number->currency($clientLoanPaymentData[$arraySize-1]['final_loan_amount']);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-lg-3" scope="row"><?= __('Total Installment Received') ?></th>
                        <td class="col-lg-3">
                            <?php
                            $totalInstallment = 0;
                            foreach ($clientLoanPaymentData as $data)
                            {
                                $totalInstallment += $data['installment_received'];
                            }
                            echo $this->Number->currency($totalInstallment);
                            //                        debug($clientRdPaymentData);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-lg-3" scope="row"><?= __('Total Interest Received') ?></th>
                        <td class="col-lg-3">
                            <?php
                            $totalInterest = 0;
                            foreach ($clientLoanPaymentData as $data)
                            {
                                $totalInterest += $data['interest_received'];
                            }
                            echo $this->Number->currency($totalInterest);
                            //                        debug($clientRdPaymentData);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-lg-3" scope="row"><?= __('Last Payment Date') ?></th>
                        <td class="col-lg-3">
                            <?php
                            $arraySize = sizeof($clientLoanPaymentData);
                            echo $clientLoanPaymentData[$arraySize-1]['created_date']->nice();
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
