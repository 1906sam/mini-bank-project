<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($theme['title']) ? $theme['title'] : 'AdminLTE 2'; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap'); ?>
    <?php if($_SERVER['REQUEST_URI'] == '/addFd' || $_SERVER['REQUEST_URI'] == '/addLoan' || $_SERVER['REQUEST_URI'] == '/addRd') { ?>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <style>
            /* this original for Autocomplete Combobox */
            .ui-button { margin-left: -1px; }
            .ui-button-icon-only .ui-button-text { padding: 0.35em; }
            .ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
            /* *** Add this for visible Scrolling ;) */
            .ui-autocomplete {
                max-height: 350px;
                overflow-y: scroll;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
                /* add padding to account for vertical scrollbar */
                padding-right: 20px;
            }
            /* IE 6 doesn't support max-height
             * we use height instead, but this forces the menu to always be this tall
             */
            * html .ui-autocomplete {
                height: 100px;
            }
            .custom-combobox {
                position: relative;
                display: inline-block;
            }
            .custom-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
            }
            .custom-combobox-input {
                margin: 0;
                padding: 5px 10px;
            }


        </style>
    <?php } ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <?php if($_SERVER['HTTP_HOST'] == 'localhost') { ?>
        <link rel="stylesheet" href="http://localhost/Bank_project/css/style.css">
    <?php } else { ?>
        <link rel="stylesheet" href="http://bnkprj.dev/css/style.css">
    <?php } ?>
    <!-- jQuery 2.1.4 -->
    <?php echo $this->Html->script('AdminLTE./plugins/jQuery/jQuery-2.1.4.min'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/pdfmake-0.1.18/dt-1.10.13/af-2.1.3/b-1.2.4/b-colvis-1.2.4/b-flash-1.2.4/b-html5-1.2.4/b-print-1.2.4/kt-2.2.0/r-2.1.1/se-1.2.0/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <!--  for jquery ui  -->
    <?php if($_SERVER['REQUEST_URI'] == '/addFd' || $_SERVER['REQUEST_URI'] == '/addLoan' || $_SERVER['REQUEST_URI'] == '/addRd') { ?>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script>
            $( function() {
                $.widget( "custom.combobox", {
                    _create: function() {
                        this.wrapper = $( "<span>" )
                            .addClass( "custom-combobox" )
                            .insertAfter( this.element );

                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                    },

                    _createAutocomplete: function() {
                        var selected = this.element.children( ":selected" ),
                            value = selected.val() ? selected.text() : "";

                        this.input = $( "<input>" )
                            .appendTo( this.wrapper )
                            .val( value )
                            .attr( "title", "" )
                            .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
                            .autocomplete({
                                delay: 0,
                                minLength: 0,
                                source: $.proxy( this, "_source" )
                            })
                            .tooltip({
                                classes: {
                                    "ui-tooltip": "ui-state-highlight"
                                }
                            });

                        this._on( this.input, {
                            autocompleteselect: function( event, ui ) {
                                ui.item.option.selected = true;
                                this._trigger( "select", event, {
                                    item: ui.item.option
                                });
                            },

                            autocompletechange: "_removeIfInvalid"
                        });
                    },

                    _createShowAllButton: function() {
                        var input = this.input,
                            wasOpen = false;

                        $( "<a>" )
                            .attr( "tabIndex", -1 )
                            .attr( "title", "Show All Items" )
                            .tooltip()
                            .appendTo( this.wrapper )
                            .button({
                                icons: {
                                    primary: "ui-icon-triangle-1-s"
                                },
                                text: false
                            })
                            .removeClass( "ui-corner-all" )
                            .addClass( "custom-combobox-toggle ui-corner-right" )
                            .on( "mousedown", function() {
                                wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                            })
                            .on( "click", function() {
                                input.trigger( "focus" );

                                // Close if already visible
                                if ( wasOpen ) {
                                    return;
                                }

                                // Pass empty string as value to search for, displaying all results
                                input.autocomplete( "search", "" );
                            });
                    },

                    _source: function( request, response ) {
                        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                        response( this.element.children( "option" ).map(function() {
                            var text = $( this ).text();
                            if ( this.value && ( !request.term || matcher.test(text) ) )
                                return {
                                    label: text,
                                    value: text,
                                    option: this
                                };
                        }) );
                    },

                    _removeIfInvalid: function( event, ui ) {

                        // Selected an item, nothing to do
                        if ( ui.item ) {
                            return;
                        }

                        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                            valueLowerCase = value.toLowerCase(),
                            valid = false;
                        this.element.children( "option" ).each(function() {
                            if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                                this.selected = valid = true;
                                return false;
                            }
                        });

                        // Found a match, nothing to do
                        if ( valid ) {
                            return;
                        }

                        // Remove invalid value
                        this.input
                            .val( "" )
                            .attr( "title", value + " didn't match any item" )
                            .tooltip( "open" );
                        this.element.val( "" );
                        this._delay(function() {
                            this.input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        this.input.autocomplete( "instance" ).term = "";
                    },

                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    }
                });

                $( "#combobox" ).combobox();
                $( "#toggle" ).on( "click", function() {
                    $( "#combobox" ).toggle();
                });
            } );
        </script>
    <?php } ?>

    <!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
<!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <?php echo $this->Html->css('AdminLTE.skins/skin-blue'); ?>

    <?php echo $this->fetch('css'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div style="width: 50px; height: 50px; position: absolute; float: right; z-index: 1000000; margin-left: 1300px;margin-top: 550px;" data-toggle="modal" data-target="#calculateModal">
    <img style="height: 100%;" src="http://icons.iconarchive.com/icons/pelfusion/long-shadow-media/512/Calculator-icon.png">
<!--    <img style="height: 100%" src="/img/install_coffee.jpg" data-toggle="modal" data-target="calculateModal">-->
</div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><?php echo "BP" ?></span>
                <!-- logo for regular state and mobile devices -->
<!--                <span class="logo-lg">--><?php //echo "Bank Project" ?><!--</span>-->
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <?php echo $this->element('nav-top') ?>
        </header>

        <!-- Left side column. contains the sidebar -->
        <?php echo $this->element('aside-main-sidebar'); ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Flash->render('auth'); ?>
            <?php echo $this->fetch('content'); ?>

        </div>
        <!-- /.content-wrapper -->

        <?php echo $this->element('footer'); ?>

        <!-- Control Sidebar -->
        <?php echo $this->element('aside-control-sidebar'); ?>

        <!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

    <!-- Bootstrap 3.3.5 -->
<?php //echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap'); ?>
    <?php
        if($_SERVER['REQUEST_URI'] == '/addFd' || $_SERVER['REQUEST_URI'] == '/addLoan' || $_SERVER['REQUEST_URI'] == '/addRd') { ?>
        <script>
            $.fn.bootstrapBtn = $.fn.button.noConflict();
        </script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <?php } ?>

<!-- SlimScroll -->
<?php echo $this->Html->script('AdminLTE./plugins/slimScroll/jquery.slimscroll.min'); ?>
<!-- FastClick -->
<?php echo $this->Html->script('AdminLTE./plugins/fastclick/fastclick'); ?>
<!-- AdminLTE App -->
<?php echo $this->Html->script('AdminLTE.AdminLTE.min'); ?>
<!-- AdminLTE for demo purposes -->
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBotton'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".navbar .menu").slimscroll({
            height: "200px",
            alwaysVisible: false,
            size: "3px"
        }).css("width", "100%");

        var a = $('a[href="<?php echo $this->request->webroot . $this->request->url ?>"]');
        if (!a.parent().hasClass('treeview')) {
            a.parent().addClass('active').parents('.treeview').addClass('active');
        }
    });
</script>
<style>
    .test
    {
        display: none;
    }
</style>
<div id="calculateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Data</h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create(null,['method' => 'POST','id' => 'calculateFormId','name' => 'calculateNameForm','url' => '/admin/calculateMaturity','class'=>'form']) ?>
                <?php
                //echo $this->Form->input('clientIdArray',['id' => 'clientIdValues','type' => 'hidden']);
                    echo '<input type="hidden" name="clientId" id="clientIdValues" />';
                    echo $this->Form->input('select_cal_type',['label' => 'Calculation type','id' => 'calculationId','options' => ['1' => 'Recurring Deposit', '2' => 'Fixed Deposit'],'onclick' => 'selectCalculationType(this);','type' => 'select','required' => 'required']);
                    echo '<div id="idForRd">';
                    echo '<div class="form-group text required"><input type="text" id="rd_amount" name="rd_amount" class="form-control" placeholder="Enter RD Amount" /></div>';
                    echo '<div class="form-group text required"><input type="text" id="rd_months" name="rd_months" placeholder="Total Months" class="form-control" /></div>';
                    echo '<div class="form-group text required"><input type="text" id="rd_interest" name="rd_interest" placeholder="Interest" class="form-control" /></div>';
                    echo '<div class="form-group text required">'.$this->Form->label(null,'Maturity amount:',['class' => 'form-control','id' => 'amt_label1']).'</div>';
                    echo '</div>';
                    echo '<div id="idForFd" style="display: none;">';
                    echo '<div class="form-group text required"><input type="text" id="fd_amount" name="fd_amount" class="form-control" placeholder="Enter FD Amount" /></div>';
                    echo '<div class="form-group text required"><input type="text" id="fd_quaters" name="fd_quaters" placeholder="Total Quaters" class="form-control" /></div>';
                    echo '<div class="form-group text required"><input type="text" id="fd_interest" name="fd_interest" placeholder="Interest" class="form-control" /></div>';
                    echo '<div class="form-group text required">'.$this->Form->label(null,'Maturity amount:',['class' => 'form-control amt_label','id' => 'amt_label2']).'</div>';
                    echo '</div>';
                ?>
                <button type="button" onclick="submitCalculationFormData()" class="btn btn-success" >Submit</button>
                <?php echo $this->Form->end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jsCookie.js"></script>
<script>
    function selectCalculationType(reference) {
        if(reference.value == 1)
        {
            document.getElementById('idForFd').style.display = "none";
            document.getElementById('idForRd').style.display = "block";

            $('#rd_amount').attr('required','required');
            $('#rd_months').attr('required','required');
            $('#rd_interest').attr('required','required');

            $('#fd_amount').val('');
            $('#fd_quaters').val('');
            $('#fd_interest').val('');
            $('#fd_amount').removeAttr('required');
            $('#fd_quaters').removeAttr('required');
            $('#fd_interest').removeAttr('required');
        }
        else
        {
            document.getElementById('idForRd').style.display = "none";
            document.getElementById('idForFd').style.display = "block";

            $('#fd_amount').attr('required','required');
            $('#fd_quaters').attr('required','required');
            $('#fd_interest').attr('required','required');

            $('#rd_amount').val('');
            $('#rd_months').val('');
            $('#rd_interest').val('');
            $('#rd_amount').removeAttr('required');
            $('#rd_months').removeAttr('required');
            $('#rd_interest').removeAttr('required');
        }
    }

    function submitCalculationFormData() {
        var element = document.querySelector("form");
        element.addEventListener("submit", function(event) {
            event.preventDefault();
        });

        var webURL = location.protocol + "//" + location.host;
        var csrfToken = Cookies.get('csrfToken');
        var calValue = document.getElementById('calculationId').value;
        var amount=0,duration=0,interest = 0;
        if(calValue == 1)
        {
            amount = document.getElementById('rd_amount').value;
            duration = document.getElementById('rd_months').value;
            interest = document.getElementById('rd_interest').value;
        }
        else
        {
            amount = document.getElementById('fd_amount').value;
            duration = document.getElementById('fd_quaters').value;
            interest = document.getElementById('fd_interest').value;
        }
        $.ajax({
            url: webURL + '/admin/calculateMaturity',
            type: "POST",
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            },
            data: {
                calValue : calValue,
                amount : amount,
                duration : duration,
                interest : interest
            },
            success: function (data)
            {
                //document.getElementsByClassName('amt_label').innerHTML
                document.getElementById('amt_label'+calValue).innerHTML = "Maturity amount: "+data;
//                alert(data);
            }
        });

//        return false;
    }
</script>
</body>
</html>
