<div class="page-title">
    <div class="title_left">
        <h3><?=$page_title?> Page</h3>
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xs-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>List data</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled msg_list">
                                    <li>
                                        <a>
                                            <span>
                                                <span>From: <?=$view['customer_name']?></span>
                                                <span class="time"><?=$view['created_date']?></span>
                                            </span>
                                        </a>
                                        
                                    </li>
                                    <li>
                                        <a>
                                            <span>
                                                <span>Email: <?=$view['customer_email']?></span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span>
                                                <span>IP Address: <?=$view['customer_ip_address']?></span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="customer-inbox-jumbotron jumbotron pt-4" style="background-color: #fff;border: 2px dashed">
                                    <p>Subject</p>
                                    <h4 class="display-4"><?=$view['customer_subject']?></h4>
                                    <hr class="my-4">
                                    <p><?=$view['customer_message']?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-8">
                                <a class="btn btn-primary" href="<?=$cancel_url?>">Back</a>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                </div>
            </div><!-- End of x_content -->
        </div>
    </div>
</div>
