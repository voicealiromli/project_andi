<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->config->item('app_abbr') ?> :: <?php echo $this->config->item('app_name') . ' ' . $this->config->item('app_ver') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="<?php echo $this->config->item('author') ?>">
        <meta name="robots" content="noindex, nofollow">

        <link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/responsive.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/jquery-ui-1.8.22.custom.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/datepicker.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/flat.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url() ?>assets/img/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url() ?>assets/ico/144.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url() ?>assets/ico/72.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url() ?>assets/ico/57.png">
        <script src="<?php echo base_url('assets/js/jquery-1.8.0.min.js') ?>"></script>
        <!--
    <script src="<?php echo base_url('assets/js/jquery-ui-1.8.22.custom.js') ?>"></script>
        -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    </head>

    <body>

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand " href="<?php echo site_url() ?>"><?php echo $this->config->item('app_abbr') ?></a>
                    <div class="nav-collapse collapse">
                        <?php $page = current_url() ?>
                        <ul class="nav">

                            <?php if ($this->model_session->auth_display('user', 4) || $this->model_session->auth_display('role', 4) || $this->model_session->auth_display('log', 4) || $this->model_session->auth_display('Department', 4)): ?>
                                <li class="dropdown<?php echo (strstr($page, 'user') || strstr($page, 'role') || strstr($page, 'log') || strstr($page, 'Department')) ? ' active' : NULL; ?>">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench icon-white"></i> Konfigurasi <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <?php if ($this->model_session->auth_display('user', 4)): ?>
                                            <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('user') ?>"> Pengguna </a></li>
                                        <?php endif; ?>
										<!-- 
										-->
                                        <?php if ($this->model_session->auth_display('role', 4)): ?>
                                            <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('role') ?>"> Role </a></li>
                                        <?php endif; ?>				
                                        <?php if ($this->model_session->auth_display('log', 4)): ?>
                                            <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('log') ?>"> Log </a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
							
							<!-- 
							<?php if ($this->model_session->auth_display('category', 2)): ?>			
                                <li class="<?php echo (strstr($page, 'category')) ? 'active' : NULL; ?>"><a id="hidelink" href="javascript:;" rel="<?php echo site_url('category') ?>" title="Laporan"><i class="icon-list-alt icon-white"></i> Jenis Dokumen </a></li>
                            <?php endif; ?>
							-->

                            <?php if ($this->model_session->auth_display('document', 2)): ?>
                                <li class="dropdown<?php echo (strstr($page, 'doc')) ? ' active' : NULL; ?>">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book icon-white"></i> Dokumen <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <?php if ($this->model_session->auth_display('document', 2)): ?>
                                            <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('doc/a') ?>">Buat Baru</a></li>
                                        <?php endif; ?>
										
                                        <?php if ($this->model_session->auth_display('document', 2)): ?>
                                            <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('doc') ?>">Daftar Dokumen</a></li>
                                        <?php endif; ?>
										
                                        <?php if ($this->model_session->auth_display('document', 2)): ?>
                                            <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('doc/box') ?>">Daftar Box</a></li>
                                        <?php endif; ?>
										
                                        <?php /* if($this->model_session->auth_display('document', 2)):?>
                                          <li><a href="<?php echo site_url('doc/search_content')?>">Pencarian Konten</a></li>
                                          <?php endif;?>
                                          <?php if($this->model_session->auth_display('document', 2)):?>
                                          <li><a href="<?php echo site_url('doc/search')?>"> Pencarian Lanjutan </a></li>
                                          <?php endif; */ ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
							
							<!--li class="<?php echo (strstr($page, 'upzip'))?'active':NULL;?>"><a id="hidelink" href="javascript:;" rel="<?php echo site_url('upzip/file')?>" title="Laporan"><i class="icon-folder-open<?php echo (strstr($page, 'upzip'))?'':' icon-white';?>"></i> Upload Zip </a></li-->
							
							<?php if ($this->model_session->auth_display('report', 2)): ?>
                                <li class="<?php echo (strstr($page, 'report')) ? 'active' : NULL; ?>"><a id="hidelink" href="javascript:;" rel="<?php echo site_url('report') ?>" title="Laporan"><i class="icon-folder-open icon-white"></i> Laporan </a></li>
                            <?php endif; ?>

<!--<li class="<?php //echo (strstr($page, 'search'))?'active':NULL;   ?>"><a href="<?php //echo site_url('search')   ?>" title="Search"><i class="icon-search icon-white"></i> Search</a></li>-->

                        </ul><!--/left nav-->

                        <ul class="nav pull-right">
                            <li class="dropdown<?php echo ($page == 'account') ? ' active' : '' ?>">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> <?php echo '<small>' . $this->session->userdata('uFname') . '</small>' ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                      <!--<li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('bug') ?>"><i class="icon-warning-sign"></i> Laporkan Bug</a></li>-->
                                    <li><a id="hidelink" href="javascript:;" rel="<?php echo site_url('user/chgpwd') ?>"><i class="icon-lock"></i> Ganti Kata Sandi</a></li>
                                    <li><a href="<?php echo site_url('logout') ?>" title="Keluar Sistem"><i class="icon-off"></i> Keluar</a></li>
                                </ul>
                            </li>
                        </ul>

                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="clearfix">&nbsp;</div>

        <div class="container-fluid">

            <?php
            echo ( ( $this->session->flashdata('error') ) ? '<div class="alert alert-error">' . $this->session->flashdata('error') . '</div>' : NULL );
            echo ( ( $this->session->flashdata('success') ) ? '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>' : NULL );
            ?>