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
                    <td><?= $this->Number->format($clientDetail->status) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Client Sign Photo') ?></th>
                    <td><img src="<?= h($clientDetail->client_sign_photo) ?>" width="80" height="40"></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created Date') ?></th>
                    <td><?= h($clientDetail->created_date) ?></td>
                </tr>
                <!--                <tr>-->
                <!--                    <th scope="row">--><?php //__('Modified Date') ?><!--</th>-->
                <!--                    <td>--><?php //h($clientDetail->modified_date) ?><!--</td>-->
                <!--                </tr>-->
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <!-- for left side table -->
        <div class="tablemarg tableui col-md-6" >
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
                    <td><?= h($clientDetail->created_date) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- for right side table -->
        <div class="tablemarg tableui col-md-5" >
            <table class="table table-responsive table-striped">
                <tbody>
                <caption >RD Details</caption>
                <tr>
                    <th class="col-lg-3" scope="row"><?= __('Total Amount Invested') ?></th>
                    <td class="col-lg-3">
                        <?php
                            $totalInvestment = 0;
                            foreach ($clientRdPaymentData as $data)
                            {
                                $totalInvestment += $data['installment_received'];
                            }
                        ?>
                    </td>
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
                    <td><?= h($clientDetail->created_date) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
