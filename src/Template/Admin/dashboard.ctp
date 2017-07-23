<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua-gradient">
                <div class="inner">
                    <h3><?= $clientCount; ?></h3>
                    <p>Total Active Clients</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="/viewClients" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- RD Deposites -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red-gradient">
                <div class="inner">
                    <h3><?= $clientRdData; ?></h3>
                    <p>Active RD Deposit</p>
                </div>
                <div class="icon">
                    <i class="fa fa-inr"></i>
                </div>
                <a href="/viewRdPayment" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua-gradient">
                <div class="inner">
                    <h3><?= $clientFdCount; ?></h3>

                    <p>Active FD Clients</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="/viewFdInformation" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- FD Deposites -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box  bg-yellow-gradient">
                <div class="inner">
                    <h3><?= $clientFdData; ?></h3>
                    <p>Active FD Deposit</p>
                </div>
                <div class="icon">
                    <i class="fa fa-inr"></i>
                </div>
                <a href="/viewFdInformation" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua-gradient">
                <div class="inner">
                    <h3><?= $clientLoanCount; ?></h3>

                    <p>Active Loan Clients</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="/viewLoanInformation" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Loan Deposites -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green-gradient">
                <div class="inner">
                    <h3><?= $clientLoanData; ?></h3>
                    <p>Active Loan Deposit</p>
                </div>
                <div class="icon">
                    <i class="fa fa-inr"></i>
                </div>
                <a href="/viewLoanPayment" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row" style="margin: 20px; background-color: white; padding: 20px; -moz-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.6); -o-box-shadow: 0 0 10px rgba(0,0,0,0.6);">
        <!-- Left col -->
<!--        <section class="col-lg-5 connectedSortable">-->
        <div class="row">
        <div class="col-md-8" style="text-align: center; margin: 0 auto; float: none;">
            <p style="text-align: center; font-size: x-large; text-decoration: underline">Cash summary</p>
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('FD Cash Inward') ?> <span style="font-weight: normal;">(Sum of all running FD's amount)</span></th>
                    <td><?= $this->Number->currency($clientRunFdData) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('FD Cash Outward') ?> <span style="font-weight: normal;"> (Sum of all closed FD's terminating amount)</span></th>
                    <td><?= $this->Number->currency($clientComFdData) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('RD Cash Inward') ?><span style="font-weight: normal;"> (Sum of Installments and penalty for all Running RD)</span></th>
                    <td><?= $this->Number->currency($totalRunningRdInwardCash) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('RD Cash Outward') ?><span style="font-weight: normal;"> (Sum of all RDs terminating amount minus sum of all RDs penalty )</span></th>
                    <td><?= $this->Number->currency($totalRunningRdOutwardCash) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Loan Cash Inward') ?><span style="font-weight: normal;"> (Sum of interest and installment received of all running loan)</span></th>
                    <td><?= $this->Number->currency($totalRunningLoanInwardCash) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Loan Cash Outward') ?><span style="font-weight: normal;"> (Sum of all the loan given)</span></th>
                    <td><?= $this->Number->currency($clientLoanData) ?></td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center; background-color: #2aabd2"><?= __('Net Cash Left') ?></th>
                    <td style="text-align: center; background-color: #2aabd2"><?=
                        $this->Number->currency($clientRunFdData - $clientComFdData + $totalRunningRdInwardCash - $totalRunningRdOutwardCash +
                            $totalRunningLoanInwardCash - $clientLoanData);
                        ?>
                    </td>
                </tr>
            </table>
<!--            <table id="clientSummaryTable" target="_blank" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>S.No.</th>-->
<!--                    <th>FD Cash Inward</th>-->
<!--                    <th>FD Cash Outward</th>-->
<!--                    <th>RD Cash Inward</th>-->
<!--                    <th>RD Cash Outward</th>-->
<!--                    <th>Loan Cash Inward</th>-->
<!--                    <th>Loan Cash Outward</th>-->
<!--                    <th>Net cash Left</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                --><?php //$count = 0; $class = "";
//                foreach ($clientLoanPayments as $payment):
//                    $count++;
//                    if($count %2 == 0)
//                        $class = "";
//                    else
//                        //$class = "success";
//                        ?>
<!--                        <tr>-->
<!--                        <td>--><?php //echo $this->Number->format($count) ?><!--</td>-->
<!--                    <td>--><?php //echo $this->Html->link($clientLoanInfo[$payment->client_loan_id], ['controller' => 'ClientDetails', 'action' => 'view', $clientLoanDataValue[$payment->client_loan_id]]); ?><!--</td>-->
<!--                    <td>--><?php //echo $this->Number->currency($payment->final_loan_amount) ?><!--</td>-->
<!--                    <td>--><?php //echo h($payment->created_date->addMonth(1)->nice()) ?><!--</td>-->
<!--                    </tr>-->
<!--                --><?php //endforeach; ?>
<!--                </tbody>-->
<!--            </table>-->
<!--            --><?php //if(sizeof($clientLoanPayments) > 10)  { ?>
<!--                <a href="/viewLoanPayment"><p style="text-align: right;cursor: pointer; text-decoration: underline; color: blue">View more...</p></a>-->
<!--            --><?php //} ?>
        </div>
        </div>

        <br><br>
        <div class="row">
<!-- previous two tables (RD/Loan)-->
            <div class="col-lg-6">
                <p style="text-align: center; font-size: x-large; text-decoration: underline">Last 10 RD Payments</p>
                <table id="clientRdTable" target="_blank" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
                    <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Client Name</th>
                        <th>RD Amount</th>
                        <th>Payment Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; $class = "";
                    foreach ($clientRdPayments as $payment):
                        $count++;
                        if($count %2 == 0)
                            $class = "";
                        else
                            //$class = "success";
                            ?>
                        <tr>
                        <td><?php echo $this->Number->format($count) ?></td>
                        <td><?php echo $this->Html->link($clientRdInfo[$payment->client_rd_id], ['controller' => 'ClientDetails', 'action' => 'view', $clientRdDataValue[$payment->client_rd_id]],['target' => '_blank']); ?></td>
                        <td><?php echo $this->Number->currency($payment->installment_received) ?></td>
                        <td><?php echo h($payment->created_date->format("Y-m-d")) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(sizeof($clientRdPayments) > 5)  { ?>
                <a href="/viewRdPayment" target="_blank"><p style="text-align: right;cursor: pointer; text-decoration: underline; color: blue">View more...</p></a>
                <?php } ?>
            </div>
            <div class="col-lg-6">
            <p style="text-align: center; font-size: x-large; text-decoration: underline">Last 10 Loan Payments</p>
            <table id="clientRdTable" target="_blank" class="table table-striped table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0"  width="100%">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Client Name</th>
                    <th>Loan Amount Left</th>
                    <th>Next Payment Date</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 0; $class = "";
                foreach ($clientLoanPayments as $payment):
                    $count++;
                    if($count %2 == 0)
                        $class = "";
                    else
                        //$class = "success";
                        ?>
                        <tr>
                        <td><?php echo $this->Number->format($count) ?></td>
                    <td><?php echo $this->Html->link($clientLoanInfo[$payment->client_loan_id], ['controller' => 'ClientDetails', 'action' => 'view', $clientLoanDataValue[$payment->client_loan_id]],['target' => '_blank']); ?></td>
                    <td><?php echo $this->Number->currency($payment->final_loan_amount) ?></td>
                    <td><?php echo h($payment->created_date->format("Y-m-d")) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(sizeof($clientLoanPayments) > 5)  { ?>
            <a href="/viewLoanPayment" target="_blank"><p style="text-align: right;cursor: pointer; text-decoration: underline; color: blue">View more...</p></a>
            <?php } ?>
        </div>
        </div>
<!-- Two tables code ends here -->

            <!-- Custom tabs (Charts with tabs)-->
<!--            <div class="nav-tabs-custom">-->
<!--                <!-- Tabs within a box -->
<!--                <ul class="nav nav-tabs pull-right">-->
<!--                    <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>-->
<!--                    <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>-->
<!--                    <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>-->
<!--                </ul>-->
<!--                <div class="tab-content no-padding">-->
<!--                    <!-- Morris chart - Sales -->
<!--                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>-->
<!--                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>-->
<!--                </div>-->
<!--            </div>-->
            <!-- /.nav-tabs-custom -->

            <!-- Chat box -->
            <!--          <div class="box box-success">-->
            <!--            <div class="box-header">-->
            <!--              <i class="fa fa-comments-o"></i>-->
            <!---->
            <!--              <h3 class="box-title">Chat</h3>-->
            <!---->
            <!--              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">-->
            <!--                <div class="btn-group" data-toggle="btn-toggle">-->
            <!--                  <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>-->
            <!--                  </button>-->
            <!--                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--            <div class="box-body chat" id="chat-box">-->
            <!--              <!-- chat item -->
            <!--              <div class="item">-->
            <!--                --><?php //echo $this->Html->image('user4-128x128.jpg', ['alt' => 'user image', 'class' => 'online']); ?>
            <!---->
            <!--                <p class="message">-->
            <!--                  <a href="#" class="name">-->
            <!--                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>-->
            <!--                    Mike Doe-->
            <!--                  </a>-->
            <!--                  I would like to meet you to discuss the latest news about-->
            <!--                  the arrival of the new theme. They say it is going to be one the-->
            <!--                  best themes on the market-->
            <!--                </p>-->
            <!--                <div class="attachment">-->
            <!--                  <h4>Attachments:</h4>-->
            <!---->
            <!--                  <p class="filename">-->
            <!--                    Theme-thumbnail-image.jpg-->
            <!--                  </p>-->
            <!---->
            <!--                  <div class="pull-right">-->
            <!--                    <button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--                <!-- /.attachment -->
            <!--              </div>-->
            <!--              <!-- /.item -->
            <!--              <!-- chat item -->
            <!--              <div class="item">-->
            <!--              --><?php //echo $this->Html->image('user3-128x128.jpg', ['alt' => 'user image', 'class' => 'offline']); ?>
            <!---->
            <!--                <p class="message">-->
            <!--                  <a href="#" class="name">-->
            <!--                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>-->
            <!--                    Alexander Pierce-->
            <!--                  </a>-->
            <!--                  I would like to meet you to discuss the latest news about-->
            <!--                  the arrival of the new theme. They say it is going to be one the-->
            <!--                  best themes on the market-->
            <!--                </p>-->
            <!--              </div>-->
            <!--              <!-- /.item -->
            <!--              <!-- chat item -->
            <!--              <div class="item">-->
            <!--                --><?php //echo $this->Html->image('user2-160x160.jpg', ['alt' => 'user image', 'class' => 'offline']); ?>
            <!---->
            <!--                <p class="message">-->
            <!--                  <a href="#" class="name">-->
            <!--                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>-->
            <!--                    Susan Doe-->
            <!--                  </a>-->
            <!--                  I would like to meet you to discuss the latest news about-->
            <!--                  the arrival of the new theme. They say it is going to be one the-->
            <!--                  best themes on the market-->
            <!--                </p>-->
            <!--              </div>-->
            <!--              <!-- /.item -->
            <!--            </div>-->
            <!--            <!-- /.chat -->
            <!--            <div class="box-footer">-->
            <!--              <div class="input-group">-->
            <!--                <input class="form-control" placeholder="Type message...">-->
            <!---->
            <!--                <div class="input-group-btn">-->
            <!--                  <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--          </div>-->
            <!-- /.box (chat box) -->

            <!-- TO DO List -->
            <!--          <div class="box box-primary">-->
            <!--            <div class="box-header">-->
            <!--              <i class="ion ion-clipboard"></i>-->
            <!---->
            <!--              <h3 class="box-title">To Do List</h3>-->
            <!---->
            <!--              <div class="box-tools pull-right">-->
            <!--                <ul class="pagination pagination-sm inline">-->
            <!--                  <li><a href="#">&laquo;</a></li>-->
            <!--                  <li><a href="#">1</a></li>-->
            <!--                  <li><a href="#">2</a></li>-->
            <!--                  <li><a href="#">3</a></li>-->
            <!--                  <li><a href="#">&raquo;</a></li>-->
            <!--                </ul>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--            <!-- /.box-header -->
            <!--            <div class="box-body">-->
            <!--              <ul class="todo-list">-->
            <!--                <li>-->
            <!--                  <!-- drag handle -->
            <!--                      <span class="handle">-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                      </span>-->
            <!--                  <!-- checkbox -->
            <!--                  <input type="checkbox" value="" name="">-->
            <!--                  <!-- todo text -->
            <!--                  <span class="text">Design a nice theme</span>-->
            <!--                  <!-- Emphasis label -->
            <!--                  <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>-->
            <!--                  <!-- General tools such as edit or delete-->
            <!--                  <div class="tools">-->
            <!--                    <i class="fa fa-edit"></i>-->
            <!--                    <i class="fa fa-trash-o"></i>-->
            <!--                  </div>-->
            <!--                </li>-->
            <!--                <li>-->
            <!--                      <span class="handle">-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                      </span>-->
            <!--                  <input type="checkbox" value="" name="">-->
            <!--                  <span class="text">Make the theme responsive</span>-->
            <!--                  <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>-->
            <!--                  <div class="tools">-->
            <!--                    <i class="fa fa-edit"></i>-->
            <!--                    <i class="fa fa-trash-o"></i>-->
            <!--                  </div>-->
            <!--                </li>-->
            <!--                <li>-->
            <!--                      <span class="handle">-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                      </span>-->
            <!--                  <input type="checkbox" value="" name="">-->
            <!--                  <span class="text">Let theme shine like a star</span>-->
            <!--                  <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>-->
            <!--                  <div class="tools">-->
            <!--                    <i class="fa fa-edit"></i>-->
            <!--                    <i class="fa fa-trash-o"></i>-->
            <!--                  </div>-->
            <!--                </li>-->
            <!--                <li>-->
            <!--                      <span class="handle">-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                      </span>-->
            <!--                  <input type="checkbox" value="" name="">-->
            <!--                  <span class="text">Let theme shine like a star</span>-->
            <!--                  <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>-->
            <!--                  <div class="tools">-->
            <!--                    <i class="fa fa-edit"></i>-->
            <!--                    <i class="fa fa-trash-o"></i>-->
            <!--                  </div>-->
            <!--                </li>-->
            <!--                <li>-->
            <!--                      <span class="handle">-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                      </span>-->
            <!--                  <input type="checkbox" value="" name="">-->
            <!--                  <span class="text">Check your messages and notifications</span>-->
            <!--                  <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>-->
            <!--                  <div class="tools">-->
            <!--                    <i class="fa fa-edit"></i>-->
            <!--                    <i class="fa fa-trash-o"></i>-->
            <!--                  </div>-->
            <!--                </li>-->
            <!--                <li>-->
            <!--                      <span class="handle">-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                        <i class="fa fa-ellipsis-v"></i>-->
            <!--                      </span>-->
            <!--                  <input type="checkbox" value="" name="">-->
            <!--                  <span class="text">Let theme shine like a star</span>-->
            <!--                  <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>-->
            <!--                  <div class="tools">-->
            <!--                    <i class="fa fa-edit"></i>-->
            <!--                    <i class="fa fa-trash-o"></i>-->
            <!--                  </div>-->
            <!--                </li>-->
            <!--              </ul>-->
            <!--            </div>-->
            <!--            <!-- /.box-body -->
            <!--            <div class="box-footer clearfix no-border">-->
            <!--              <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>-->
            <!--            </div>-->
            <!--          </div>-->
            <!-- /.box -->

            <!-- quick email widget -->
            <!--          <div class="box box-info">-->
            <!--            <div class="box-header">-->
            <!--              <i class="fa fa-envelope"></i>-->
            <!---->
            <!--              <h3 class="box-title">Quick Email</h3>-->
            <!--              <!-- tools box -->
            <!--              <div class="pull-right box-tools">-->
            <!--                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">-->
            <!--                  <i class="fa fa-times"></i></button>-->
            <!--              </div>-->
            <!--              <!-- /. tools -->
            <!--            </div>-->
            <!--            <div class="box-body">-->
            <!--              <form action="#" method="post">-->
            <!--                <div class="form-group">-->
            <!--                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                  <input type="text" class="form-control" name="subject" placeholder="Subject">-->
            <!--                </div>-->
            <!--                <div>-->
            <!--                  <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>-->
            <!--                </div>-->
            <!--              </form>-->
            <!--            </div>-->
            <!--            <div class="box-footer clearfix">-->
            <!--              <button type="button" class="pull-right btn btn-default" id="sendEmail">Send-->
            <!--                <i class="fa fa-arrow-circle-right"></i></button>-->
            <!--            </div>-->
            <!--          </div>-->

<!--        </section>-->
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <!--        <section class="col-lg-5 connectedSortable">-->

        <!-- Map box -->
        <!--          <div class="box box-solid bg-light-blue-gradient">-->
        <!--            <div class="box-header">-->
        <!--              <!-- tools box -->
        <!--              <div class="pull-right box-tools">-->
        <!--                <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range">-->
        <!--                  <i class="fa fa-calendar"></i></button>-->
        <!--                <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">-->
        <!--                  <i class="fa fa-minus"></i></button>-->
        <!--              </div>-->
        <!--              <!-- /. tools -->
        <!---->
        <!--              <i class="fa fa-map-marker"></i>-->
        <!---->
        <!--              <h3 class="box-title">-->
        <!--                Visitors-->
        <!--              </h3>-->
        <!--            </div>-->
        <!--            <div class="box-body">-->
        <!--              <div id="world-map" style="height: 250px; width: 100%;"></div>-->
        <!--            </div>-->
        <!--            <!-- /.box-body-->
        <!--            <div class="box-footer no-border">-->
        <!--              <div class="row">-->
        <!--                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">-->
        <!--                  <div id="sparkline-1"></div>-->
        <!--                  <div class="knob-label">Visitors</div>-->
        <!--                </div>-->
        <!--                <!-- ./col -->
        <!--                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">-->
        <!--                  <div id="sparkline-2"></div>-->
        <!--                  <div class="knob-label">Online</div>-->
        <!--                </div>-->
        <!--                <!-- ./col -->
        <!--                <div class="col-xs-4 text-center">-->
        <!--                  <div id="sparkline-3"></div>-->
        <!--                  <div class="knob-label">Exists</div>-->
        <!--                </div>-->
        <!--                <!-- ./col -->
        <!--              </div>-->
        <!--              <!-- /.row -->
        <!--            </div>-->
        <!--          </div>-->
        <!-- /.box -->

        <!-- solid sales graph -->
        <!--          <div class="box box-solid bg-teal-gradient">-->
        <!--            <div class="box-header">-->
        <!--              <i class="fa fa-th"></i>-->
        <!---->
        <!--              <h3 class="box-title">Sales Graph</h3>-->
        <!---->
        <!--              <div class="box-tools pull-right">-->
        <!--                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>-->
        <!--                </button>-->
        <!--                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>-->
        <!--                </button>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--            <div class="box-body border-radius-none">-->
<!--        <div class="chart" id="line-chart" style="height: 250px;"></div>-->
        <!--            </div>-->
        <!--            <!-- /.box-body -->
        <!--            <div class="box-footer no-border">-->
        <!--              <div class="row">-->
        <!--                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">-->
        <!--                  <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">-->
        <!---->
        <!--                  <div class="knob-label">Mail-Orders</div>-->
        <!--                </div>-->
        <!--                <!-- ./col -->
        <!--                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">-->
        <!--                  <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">-->
        <!---->
        <!--                  <div class="knob-label">Online</div>-->
        <!--                </div>-->
        <!--                <!-- ./col -->
        <!--                <div class="col-xs-4 text-center">-->
        <!--                  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">-->
        <!---->
        <!--                  <div class="knob-label">In-Store</div>-->
        <!--                </div>-->
        <!--                <!-- ./col -->
        <!--              </div>-->
        <!--              <!-- /.row -->
        <!--            </div>-->
        <!--            <!-- /.box-footer -->
        <!--          </div>-->
        <!-- /.box -->

        <!-- Calendar -->
        <!--          <div class="box box-solid bg-green-gradient">-->
        <!--            <div class="box-header">-->
        <!--              <i class="fa fa-calendar"></i>-->
        <!---->
        <!--              <h3 class="box-title">Calendar</h3>-->
        <!--              <!-- tools box -->
        <!--              <div class="pull-right box-tools">-->
        <!--                <!-- button with a dropdown -->
        <!--                <div class="btn-group">-->
        <!--                  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">-->
        <!--                    <i class="fa fa-bars"></i></button>-->
        <!--                  <ul class="dropdown-menu pull-right" role="menu">-->
        <!--                    <li><a href="#">Add new event</a></li>-->
        <!--                    <li><a href="#">Clear events</a></li>-->
        <!--                    <li class="divider"></li>-->
        <!--                    <li><a href="#">View calendar</a></li>-->
        <!--                  </ul>-->
        <!--                </div>-->
        <!--                <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>-->
        <!--                </button>-->
        <!--                <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>-->
        <!--                </button>-->
        <!--              </div>-->
        <!--              <!-- /. tools -->
        <!--            </div>-->
        <!--            <!-- /.box-header -->
        <!--            <div class="box-body no-padding">-->
        <!--              <!--The calendar -->
        <!--              <div id="calendar" style="width: 100%"></div>-->
        <!--            </div>-->
        <!--            <!-- /.box-body -->
        <!--            <div class="box-footer text-black">-->
        <!--              <div class="row">-->
        <!--                <div class="col-sm-6">-->
        <!--                  <!-- Progress bars -->
        <!--                  <div class="clearfix">-->
        <!--                    <span class="pull-left">Task #1</span>-->
        <!--                    <small class="pull-right">90%</small>-->
        <!--                  </div>-->
        <!--                  <div class="progress xs">-->
        <!--                    <div class="progress-bar progress-bar-green" style="width: 90%;"></div>-->
        <!--                  </div>-->
        <!---->
        <!--                  <div class="clearfix">-->
        <!--                    <span class="pull-left">Task #2</span>-->
        <!--                    <small class="pull-right">70%</small>-->
        <!--                  </div>-->
        <!--                  <div class="progress xs">-->
        <!--                    <div class="progress-bar progress-bar-green" style="width: 70%;"></div>-->
        <!--                  </div>-->
        <!--                </div>-->
        <!--                <!-- /.col -->
        <!--                <div class="col-sm-6">-->
        <!--                  <div class="clearfix">-->
        <!--                    <span class="pull-left">Task #3</span>-->
        <!--                    <small class="pull-right">60%</small>-->
        <!--                  </div>-->
        <!--                  <div class="progress xs">-->
        <!--                    <div class="progress-bar progress-bar-green" style="width: 60%;"></div>-->
        <!--                  </div>-->
        <!---->
        <!--                  <div class="clearfix">-->
        <!--                    <span class="pull-left">Task #4</span>-->
        <!--                    <small class="pull-right">40%</small>-->
        <!--                  </div>-->
        <!--                  <div class="progress xs">-->
        <!--                    <div class="progress-bar progress-bar-green" style="width: 40%;"></div>-->
        <!--                  </div>-->
        <!--                </div>-->
        <!--                <!-- /.col -->
        <!--              </div>-->
        <!--              <!-- /.row -->
        <!--            </div>-->
        <!--          </div>-->
        <!-- /.box -->

        <!--        </section>-->
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->

</section>
<!-- /.content -->
