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
                        <form method="POST" action="{{url('newpassword')}}">
                            @csrf
                            <div class="model-logo">
                                <img src="{{ asset('assets/images/logo.png')}}" alt="">
                                <p>لاستعادة كلمة المرور</p>
                                <input type="hidden" name="token" value="{{$token}}">
                                <input class="form-control" name="password" type="password" placeholder="كلمه السر" required>
                            </div>
                            <div class="model-button">
                                <button class="btn btn-send btn-login">إعادة تعيين كلمة المرور</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" style="display:none;" class="forget-password" id="login_modal" data-toggle="modal" data-target="#exampleModalScrollable_login" data-backdrop="static" data-keyboard="false">Login?</a>
        <script type="text/javascript" src="{{ asset('assets/js/jquery-3.3.1.slim.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#login_modal').click();
            })
        </script>
    </body>
</html>
