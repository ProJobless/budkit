<!DOCTYPE html>
<tpl:layout xmlns="http://www.w3.org/1999/xhtml" xmlns:tpl="http://tuiyo.co.uk/tpl">
    <html lang="en">
        <head>
            <title><tpl:element type="text" data="page.title">Administrator</tpl:element></title>
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
            <link rel="stylesheet" href="<?php echo $this->getTemplatePath() ?>/css/administrator.css" type="text/css" media="screen" />
            <script src='<?php echo $this->getTemplatePath() ?>/js/libs/jquery-1.7.1.min.js' type="text/javascript"></script>
            <script src='<?php echo $this->getTemplatePath() ?>/js/libs/jquery-ui.min.js' type="text/javascript"></script>
            <script src="<?php echo $this->getTemplatePath() ?>/js/libs/modernizr-2.0.6.min.js" type="text/javascript"></script>
        </head>
        <body>
            <section class="container-fixed row-fluid layout-box has-left-sidebar">
                <section class="sidebar sidebar-left">
                    <tpl:import layout="system/adminbar" />
                    <tpl:menu id="adminmenu" type="nav-block" position="left" level="2" />
                    <tpl:block data="page.block.side">Sidebar</tpl:block>
                    <div class="widget left-pad right-pad top-pad text-light">
                        <div class="widget-body">
                            <h2>2,190<small class="pull-right">60%</small></h2>
                            <div class="progress mini-bar progress-success dark">
                                <div class="bar" style="width: 60%;"></div>
                            </div>
                            <span class="help-block">New members in the last 30 days</span>
                            <h2 class="top-pad">64<small class="pull-right">10%</small></h2>
                            <div class="progress mini-bar progress-danger dark">
                                <div class="bar" style="width: 10%;"></div>
                            </div>
                            <span class="help-block">New content. Post, Check-ins etc. </span>
                            <h2 class="top-pad">583<small class="pull-right">53%</small></h2>
                            <div class="progress mini-bar progress-bar dark">
                                <div class="bar" style="width: 53%;"></div>
                            </div>
                            <span class="help-block">Relationships forged</span>
                            <h2 class="top-pad">8,943,985<small class="pull-right">90%</small></h2>
                            <div class="progress mini-bar dark">
                                <div class="bar" style="width: 90%;"></div>
                            </div>
                            <span class="help-block">Unique visitors this month</span>
                            <h2 class="top-pad">2,190<small class="pull-right">60%</small></h2>
                            <div class="progress mini-bar progress-success dark">
                                <div class="bar" style="width: 60%;"></div>
                            </div>
                            <span class="help-block">New members in the last 30 days</span>
                            <h2 class="top-pad">64<small class="pull-right">10%</small></h2>
                            <div class="progress mini-bar progress-danger dark">
                                <div class="bar" style="width: 10%;"></div>
                            </div>
                            <span class="help-block">New content. Post, Check-ins etc. </span>
                        </div>
                    </div> 
                </section>
                <section class="content-box"> 
                    <div class="container-fluid top-pad">
                        <div class="page-header">
                            <button class="btn pull-right" id="search-btn"><i class="icon-search"></i></button>
                            
                            <input type="text" class="pull-right" />
                            <h1><tpl:element type="text" data="page.title">Administrator</tpl:element></h1>
                        </div>
                        <tpl:block data="page.block.alerts" /> 
                        <tpl:condition  data="page.block.banner" test="isset" value="1" >
                            <div class="row-fluid layout-banner bottom-pad">
                                <tpl:block data="page.block.banner">Banner</tpl:block>
                            </div>
                        </tpl:condition>
                        <div>
                            <tpl:block data="page.block.body" />
                        </div>
                        <hr  />
                        <p class="text-gray" style="margin-top: 10px"><?php echo \Platform\Version::getLongVersion(); ?></p> 
                    </div>
                </section>
            </section>
        </body>
        <script src="<?php echo $this->getTemplatePath() ?>/js/bootstrap.js" type="text/javascript"></script>
        
    </html>
</tpl:layout>