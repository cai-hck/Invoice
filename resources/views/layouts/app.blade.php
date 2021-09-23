<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Nayzak Baghdad">
        <meta name="keywords" content="Nayzak Baghdad">
        <meta name="author" content="Nayzak Baghdad">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        

        <title>Nayzak Baghdad</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/logo.png')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/parsley.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css')}}">
        @yield('css')
        <style type="text/css">
            @font-face {
                font-family: IRAQSansWeb;
                src: url("{{asset('assets/fonts/IRAQSansWeb.woff2')}}");
            }
        </style>
        <style type="text/css">
            @font-face {
                font-family: IRAQSansWeb_Bold;
                src: url("{{asset('assets/fonts/IRAQSansWeb_Bold.woff2')}}");
            }
        </style>
        <style type="text/css">
            @font-face {
                font-family: IRAQSansWeb_Medium;
                src: url("{{asset('assets/fonts/IRAQSansWeb_Medium.woff2')}}");
            }
        </style>
    </head>

    <body style=" font-family: 'IRAQSansWeb_Bold'!important;">
        <div class="wrapper">
            <header class="header" id="home">
                <div class="header-bottom">
                    <div class="container">
                        <nav class="navbar navbar-expand-md navbar-dark d-flex justify-content-between">
                            <a class="navbar-brand order-0" href="#"><img src="{{asset('upload/logo/'.Auth::User()->photo)}}"></a>
                            <div class="header-search-block" >
                                <form method="POST" name="search_form" class="search-form" id="search_form">
                                    <input type="text" placeholder="بحث" name="search">
                                    <button type="button" ><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                            <div class="header-navbar ">
                                <div class="header-navbar-data float-left">
                                    <div class="collapse navbar-collapse justify-content-md-end" id="navbarNavDropdown">
                                    
                                    <ul class="navbar-nav mr-auto">
                                        <!-- <li class="nav-item ">
                                            <a class="nav-link btn btnStyle btn_warning" href="#our_services">Create an account</a>
                                        </li> -->
                                        <li class="nav-item ">
                                            <a class="nav-link btn btnStyle btn_primary"  href="{{url('/userlogout')}}">الخروج</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link btn btnStyle btn_danger" href="#home">call us</a>
                                        </li> -->
                                        
                                        
                                    </ul>
                                    </div>
                                </div>
                            </div>
                            <button class="navbar-toggler navbar-toggler-right" id="nav-icon1" type="button" data-toggle="collapse"
                            data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                            aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </nav>
                    </div>
                </div>
            </header>
            <section>
                <div class="container">
                    <div class="main-table-block">
                        <div class="tab_nevder">
                            <nav>
                                <ul>
                                    <?php if(Auth::User()->permission != 1){?>
                                        <?php if($employee->generator == '1'){?>
                                            <li><a href="{{url('/addinvoice')}}" id="addinvoice_a" class="<?php if($name == 'addinvoice'){echo 'active';}?>">اصدار فاتورة زبائن</a></li>
                                        <?php } if($employee->cashier == '1'){?>
                                            <li><a href="{{url('/addcashier')}}" id="addcashier_a" class="<?php if($name == 'addcashier'){echo 'active';}?>">الصندوق</a></li>
                                        <?php } if($employee->expenser == '1'){?>
                                            <li><a href="{{url('/addexpense')}}" id="addexpense_a" class="<?php if($name == 'addexpense'){echo 'active';}?>">اضافة فاتورة مصاريف</a></li>
                                        <?php } if($employee->generator1 == '1'){?>
                                            <li><a href="{{url('/addinvoice1')}}" id="addinvoice1_a" class="<?php if($name == 'addinvoice1'){echo 'active';}?>">اصدار فاتورة شركات</a></li>
                                        <?php } if($employee->paying == '1'){?>
                                            <li><a href="{{url('/addpaying')}}" id="addpaying_a" class="<?php if($name == 'addpaying'){echo 'active';}?>">اصدار فاتورة تسديد المصادر</a></li>
                                        <?php } if($employee->paid == '1'){?>
                                            <li><a href="{{url('/addpaid')}}" id="addpaid_a" class="<?php if($name == 'addpaid'){echo 'active';}?>">اصدار فاتورة تسديد الشركات</a></li>
                                        <?php }?>
                                    <?php }?>
                                    <?php if(Auth::User()->permission == 1){?>
                                    <li><a href="{{url('/profile')}}" class="<?php if($name == 'profile'){echo 'active';}?>">الملف الشخصي</a></li>
                                    <li><a href="{{url('/adduser')}}" class="<?php if($name == 'adduser'){echo 'active';}?>">إضافة مستخدم</a></li>
                                    <li><a href="{{url('/listuser')}}" class="<?php if($name == 'user'){echo 'active';}?>">المستخدمين</a></li>
                                    <li><a href="{{url('/addsource')}}" class="<?php if($name == 'addsource'){echo 'active';}?>">إضافة مصدر</a></li>
                                    <li><a href="{{url('/listsource')}}" class="<?php if($name == 'source'){echo 'active';}?>">قائمة المصادر</a></li>
                                    <li><a href="{{url('/addairline')}}" class="<?php if($name == 'addairline'){echo 'active';}?>">إضافة خطوط جوية</a></li>
                                    <li><a href="{{url('/listairline')}}" class="<?php if($name == 'airline'){echo 'active';}?>">قائمة الخطوط الجوية</a></li>
                                    <li><a href="{{url('/adducompany')}}" class="<?php if($name == 'adducompany'){echo 'active';}?>">إضافة مستفيد</a></li>
                                    <li><a href="{{url('/listucompany')}}" class="<?php if($name == 'ucompany'){echo 'active';}?>">قائمة المستفيدين</a></li>
                                    <?php }?>
                                    <li><a href="{{url('/report')}}" class="<?php if($name == 'report'){echo 'active';}?>">التقارير</a></li>
                                    <li style="display:none;"><a href="{{url('/pay')}}" class="<?php if($name == 'pay'){echo 'active';}?>">كشف تسديد المصادر والشركات</a></li>
                                    <li><a href="{{url('/today')}}" class="<?php if($name == 'today'){echo 'active';}?>">تنبيهات اليوم</a></li>
                                    <li><a href="{{url('/debt')}}" class="<?php if($name == 'debt'){echo 'active';}?>">الدين</a></li>
                                    <li><a href="{{url('/invoicereport')}}" class="<?php if($name == 'invoicereport'){echo 'active';}?>">كشف المبيعات</a></li>
                                    <li><a href="{{url('/invoicereport1')}}" class="<?php if($name == 'invoicereport1'){echo 'active';}?>">كشف الشركات</a></li>
                                    <li><a href="{{url('/sourcereport')}}" class="<?php if($name == 'sourcereport'){echo 'active';}?>">كشف المصادر</a></li>
                                    <li><a href="{{url('/expensereport')}}" class="<?php if($name == 'expensereport'){echo 'active';}?>">كشف المصاريف</a></li>
                                    <li><a href="{{url('/calledbox')}}" class="<?php if($name == 'calledbox'){echo 'active';}?>">الصندوق</a></li>
                                    <li><a href="{{url('/listinvoice')}}" class="<?php if($name == 'invoice'){echo 'active';}?>">صندوق مبيعات فواتير الزبائن</a></li>
                                    <li><a href="{{url('/listinvoice1')}}" class="<?php if($name == 'invoice1'){echo 'active';}?>">صندوق فواتير مبيعات الشركات</a></li>
                                    <li><a href="{{url('/listpaying')}}" class="<?php if($name == 'paying'){echo 'active';}?>">صندوق فواتير تسديد المصادر</a></li>
                                    <li><a href="{{url('/listpaid')}}" class="<?php if($name == 'paid'){echo 'active';}?>">صندوق فواتير تسديد الشركات</a></li>
                                    <li><a href="{{url('/listexpense')}}" class="<?php if($name == 'expense'){echo 'active';}?>">قائمة المصاريف </a></li>
                                </ul>
                            </nav>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </section>
            <footer>
            </footer>
        </div>
        <script type="text/javascript" src="{{ asset('assets/js/jquery-3.3.1.slim.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/popper.min.js')}}"></script>
        
        <script type="text/javascript" src="{{ asset('assets/js/moment.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/parsley.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js')}}"></script>
        <script>
            $(window).bind('scroll', function () {
                var st = $('.header').height();
                if ($(window).scrollTop() > st) {
                    $('.header').addClass('header-fixed');
                } else {
                    $('.header').removeClass('header-fixed');
                }
            });

            $('.search-label').on('click', function (event) {
                $('.search-input').toggleClass("show");
            });
            
        </script>
        <script type="text/javascript">
            $( ".date_from" ).datepicker({
                dateFormat: 'dd/mm/yy',//check change
                changeMonth: true,
                changeYear: true
            });

            $(document).ready(function(){
                $('#nav-icon1').click(function(){
                    $(this).toggleClass('open');
                });
            });
        </script>
        @yield('js')
    </body>
</html>