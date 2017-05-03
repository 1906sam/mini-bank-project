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
                <!--                <tr>-->
                <!--                    <th scope="row">--><?php // __('Client Photo') ?><!--</th>-->
                <!--                    <td>--><?php // h($clientDetail->client_photo) ?><!--</td>-->
                <!--                </tr>-->
                <tr>
                    <th scope="row"><?= __('Mobile') ?></th>
                    <td><?= $clientDetail->mobile ?></td>
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
                    <th scope="row"><?= __('Created Date') ?></th>
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
        <div class="tablemarg tableui col-md-6">
            <table class="table table-responsive table-striped">
                <tbody>
                <caption >RD Details</caption>
                <tr>
                    <th class="col-lg-3" scope="row"><?= __('Id') ?></th>
                    <td class="col-lg-3"><?= $this->Number->format($clientRdData[0]['id']) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('RD Amount') ?></th>
                    <td><?= $this->Number->currency($clientRdData[0]['rd_amount']) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Rate of Interest') ?></th>
                    <td><?= $this->Number->toPercentage($clientRdData[0]['rate_of_interest']) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Time Duration') ?></th>
                    <td><?= h($clientRdData[0]['time_duration'])." years" ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Status') ?></th>
                    <td><?php
                            if($clientRdData[0]['status'] == 0)
                                echo 'Running';
                            else
                                echo 'Closed';
                        ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created Date') ?></th>
                    <td><?= $clientRdData[0]['created_date']->nice(); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <!-- for right side table -->
        <?php if(!empty($clientRdPaymentData)) { ?>
        <div class="tablemarg tableui col-md-5" >
            <table class="table table-responsive table-striped">
                <tbody>
                <caption>Important Information</caption>
                <tr>
                    <th class="col-lg-3" scope="row"><?= __('Total Amount Invested') ?></th>
                    <td class="col-lg-3">
                        <?php
                            $totalInvestment = 0;
                            foreach ($clientRdPaymentData as $data)
                            {
                                $totalInvestment += $data['installment_received'];
                            }
                        echo $totalInvestment;
//                        debug($clientRdPaymentData);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Interest Accumulated') ?></th>
                    <td><?= ($totalInvestment * $clientRdData[0]['rate_of_interest'])/100 ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Terminating Amount') ?></th>
                    <td><?= $this->Number->currency($totalInvestment + ($totalInvestment * $clientRdData[0]['rate_of_interest'])/100) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Next Installment Date') ?></th>
                    <td>
                        <?php
                            $arraySize = sizeof($clientRdPaymentData);
                            echo $clientRdPaymentData[$arraySize-1]['created_date']->addMonth(1)->nice();
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Last Payment Date') ?></th>
                    <td>
                        <?php
                            $arraySize = sizeof($clientRdPaymentData);
                            echo $clientRdPaymentData[$arraySize-1]['created_date']->nice();
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php if(!empty($clientFdData)) { ?>
            <h3 style="text-align: center;">************************FD Section***************************</h3>
            <div class="tablemarg tableui center col-md-6" >
                <table class="table table-responsive table-striped">
                    <tbody>
                    <caption>FD Details</caption>
                    <tr>
                        <th class="col-lg-3" scope="row"><?= __('Amount Invested') ?></th>
                        <td class="col-lg-3"><?php echo $this->Number->currency($clientFdData[0]['fd_amount']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Rate of Interest') ?></th>
                        <td><?= $this->Number->toPercentage($clientFdData[0]['rate_of_interest']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Time Duration') ?></th>
                        <td><?= h($clientFdData[0]['time_duration'])." years" ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?php
                            if($clientFdData[0]['status'] == 0)
                                echo 'Running';
                            else
                                echo 'Closed';
                            ?></td>
                    <tr>
                        <th scope="row"><?= __('Terminating Amount') ?></th>
                        <td><?php
                            $finalFdAmount = ceil($clientFdData[0]['fd_amount'] * ($clientFdData[0]['rate_of_interest']/100)* $clientFdData[0]['time_duration']);
                            echo $this->Number->currency($clientFdData[0]['fd_amount'] + $finalFdAmount);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created Date') ?></th>
                        <td><?= $clientFdData[0]['created_date']->nice(); ?></td>
                    </tr>
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
