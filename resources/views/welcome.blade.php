<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        
        <title>Nayzak Baghdad</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/logo.png')}}">

        <!-- Fonts -->

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css')}}">
     
        <!-- Styles -->
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
        <!-- Modal -->
        <div class="modal fade" id="exampleModalScrollable_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="background: white;">
            <div class="modal-dialog modal-dialog-scrollable" role="document" >
                <div class="modal-content">
                    <div class="modal-body text-center" style="background: #D6D6D6;">
                        <form method="POST" action="{{url('userlogin')}}">
                            @csrf
                            <div class="model-logo">
                                <img src="{{ asset('assets/images/logo.png')}}" alt="">
                                <input class="form-control" name="email" type="email" placeholder="عنوان البريد الإلكتروني" required>
                                <input class="form-control" name="password" type="password" placeholder="كلمه السر" required>
                            </div>
                            <div class="model-button">
                                <button class="btn btn-send btn-login"> تسجيل الدخول</button>
                                <a href="#" class="forget-password" data-toggle="modal" id="forgot_modal" data-target="#exampleModalScrollable_forgot" data-backdrop="static" data-keyboard="false">هل نسيت كلمة المرور؟</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalScrollable_forgot" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="background: white;">
            <div class="modal-dialog modal-dialog-scrollable" role="document" >
                <div class="modal-content">
                    <div class="modal-body text-center" style="background: #D6D6D6;">
                        <form method="POST" action="{{url('forgotemail')}}">
                            @csrf
                            <div class="model-logo">
                                <img src="{{ asset('assets/images/logo.png')}}" alt="">
                                <p>لإعادة تعيين أدخل عنوان البريد الإلكتروني الخاص بك</p>
                                <input class="form-control" type="email " placeholder="عنوان البريد الإلكتروني" name="email" required>
                            </div>
                            <div class="model-button">
                                <button class="btn btn-send btn-login"> إعادة تعيين</button>
                                <a href="#" class="forget-password" id="login_modal" data-toggle="modal" data-target="#exampleModalScrollable_login" data-backdrop="static" data-keyboard="false">تسجيل الدخول</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('assets/js/jquery-3.3.1.slim.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#login_modal').click();
                $('#login_modal').on('click',function(){
                    $('#exampleModalScrollable_forgot').modal('toggle');
                });
                $('#forgot_modal').on('click',function(){
                    $('#exampleModalScrollable_login').modal('toggle');
                });
            })
        </script>
    </body>
</html>
