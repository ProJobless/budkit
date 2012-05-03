<!DOCTYPE html>
<tpl:layout xmlns="http://www.w3.org/1999/xhtml" xmlns:tpl="http://tuiyo.co.uk/tpl">
    <html lang="en">
        <head>
            <title><tpl:element type="text" data="page.title">Default Title</tpl:element></title>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
            <meta name="description" content="<?php echo $this->getPageDescription(); ?>" />
            <meta name="author" content="<?php echo $this->getPageAuthor(); ?>" />
            <meta name="keywords" content="<?php echo $this->getPageAuthor(); ?>" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />

            <!-- Le fav and touch icons -->
            <link rel="shortcut icon" href="images/favicon.ico" />
            <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
            <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png" />
            <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png" />

            <link rel="stylesheet" href="/~livingstonefultang/<?php echo $this->getTemplateName() ?>/css/bootstrap.css" type="text/css" media="screen" />

            <script src='/~livingstonefultang/<?php echo $this->getTemplateName() ?>/js/libs/jquery-1.7.1.min.js' type="text/javascript"></script>
            <script src='/~livingstonefultang/<?php echo $this->getTemplateName() ?>/js/libs/jquery-ui.min.js' type="text/javascript"></script>
            <script src="/~livingstonefultang/<?php echo $this->getTemplateName() ?>/js/libs/modernizr-2.0.6.min.js" type="text/javascript"></script>
        </head>

        <body>
            <tpl:menu id="sitemenu" />
            <tpl:import layout="navbar" />

            <div class="container">  
                <tpl:block data="page.block.alerts" /> 
                <tpl:block data="page.block.banner">Banner</tpl:block>
                <section class="layout-block boxed has-bg has-admin-warning">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <div class="span8">  
                                    <div class="page-header">
                                        <h1>System Manager<small>&nbsp;23/04/2012</small></h1>
                                    </div>
                                    <tpl:block data="page.block.body" />
                                </div>
                                <div class="span4">
                                    <div class="left-pad"> 
                                        <div class="btn-toolbar no-top-margin">
                                            <div class="btn-group">
                                                <button class="btn">View As</button>
                                                <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">Action</a></li>
                                                    <li><a href="#">Another action</a></li>
                                                    <li><a href="#">Something else here</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#">Separated link</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn">Edit Info</button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn"><i class="icon icon-lock"></i>Privacy</button>
                                            </div>
                                        </div>
                                        <div style="margin-top:15px">
                                            <tpl:menu id="adminmenu" type="nav-block" />
                                            
                                        </div>
                                        <tpl:block data="page.block.side">Sidebar</tpl:block>

                                        

                                        <div class="widget top-pad">
                                            <div class="widget-body">
                                                <h2>2,190<small class="pull-right">60%</small></h2>
                                                <div class="progress mini-bar progress-success">
                                                    <div class="bar" style="width: 60%;">&nbsp;</div>
                                                </div>
                                                <span class="help-block">New members in the last 30 days</span>

                                                <h2 class="top-pad">64<small class="pull-right">10%</small></h2>
                                                <div class="progress mini-bar progress-danger">
                                                    <div class="bar" style="width: 10%;">&nbsp;</div>
                                                </div>
                                                <span class="help-block">New content. Post, Check-ins etc. </span>


                                                <h2 class="top-pad">583<small class="pull-right">53%</small></h2>
                                                <div class="progress mini-bar progress-bar">
                                                    <div class="bar" style="width: 53%;">&nbsp;</div>
                                                </div>
                                                <span class="help-block">Relationships forged</span>


                                                <h2 class="top-pad">8,943,985<small class="pull-right">90%</small></h2>
                                                <div class="progress mini-bar">
                                                    <div class="bar" style="width: 90%;">&nbsp;</div>
                                                </div>
                                                <span class="help-block">Unique visitors this month</span>

                                                <h2 class="top-pad">2,190<small class="pull-right">60%</small></h2>
                                                <div class="progress mini-bar progress-success">
                                                    <div class="bar" style="width: 60%;">&nbsp;</div>
                                                </div>
                                                <span class="help-block">New members in the last 30 days</span>

                                                <h2 class="top-pad">64<small class="pull-right">10%</small></h2>
                                                <div class="progress mini-bar progress-danger">
                                                    <div class="bar" style="width: 10%;">&nbsp;</div>
                                                </div>
                                                <span class="help-block">New content. Post, Check-ins etc. </span>

                                            </div>
                                        </div>
                                        
                                        <hr />
                                        <div class="widget">
                                            <div class="well">
                                                <a href="#" class="clearfix">
                                                    <span class="count-head">Website Visits</span>
                                                    <h1 class="count-body">189</h1>
                                                    <span class="count-footer">% of Total: 5% (3702 in total)</span>
                                                </a>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section role="footer">
                    <div class="row-fluid">
                        <div class="span8">
                            <ul class="nav nav-pills">
                                <li><a href="<?php echo $this->link('/'); ?>">Home</a></li>
                                <li><a href="<?php echo $this->link('/about'); ?>">About</a></li>
                                <li><a href="<?php echo $this->link('/apps'); ?>">Apps</a></li>
                                <li><a href="http://blog.stonyhillshq.com">Blog</a></li>
                                <li><a href="http://developers.stonyhillshq.com">Developers</a></li>
                                <li><a href="<?php echo $this->link('/help'); ?>">Help</a></li>
                                <li><a href="<?php echo $this->link('/legal/privacy'); ?>">Privacy</a></li>
                                <li><a href="<?php echo $this->link('/legal/terms'); ?>">Terms</a></li>
                            </ul>
                        </div>
                        <div class="span4">
                            <ul class="nav nav-pills pull-right">
                                <li><a href="#">© Stonyhills 2012</a></li>
                            </ul>
                        </div>
                    </div>   
                    <tpl:block data="page.block.footer">Footer</tpl:block>
                    <tpl:import layout="console" />
                </section>
            </div>
            <script src="/~livingstonefultang/<?php echo $this->getTemplateName() ?>/js/bootstrap.min.js" type="text/javascript"></script>
        </body>
    </html>
</tpl:layout>