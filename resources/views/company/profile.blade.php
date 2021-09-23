@extends('layouts.app')

@section('css')
<style>
    .upload {
        width: 200px;
        border: 2px solid #ccc;
        border-radius: 10px;
        text-align: center;
        padding: 10px;
    }
    .user-plus {
        display: inline-block;
        background-color: #175593;
        color: white;
        padding: 10px;
        border-radius: 8px;
        font-size: 24px;
        margin-right: 10px;
    }
</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>الملف الشخصي</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <form  action="{{url('updateprofile')}}" method="POST" enctype="multipart/form-data" name="invoice_form" class="" id="invoice_form" >
                        @csrf
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="upload">
                                    <h4 style="color:black;background-color:white;padding:5px 5px;">اللوكو</h4>
                                    <img id="uploadedphoto" src="{{ asset('assets/images/upload.png')}}" style="width:80%;">
                                    <a href="javascript:void(0);" class="user-plus" id="preuploadphotobutton" style="background-color:#60B16E;margin-top:10px;"><span style="color:white;">تحميل اللوكو</span><img src="{{ asset('assets/images/add.png')}}"></a>
                                    <input type="file" name="photo" value="upload" id="uploadphotobutton" style="display:none" >
                                </div>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم الشركة</span>
                                </div>
                                <input type="text" name="name" aria-label="Company Name" class="form-control" placeholder="" value="{{$company->name}}" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم الهاتف</span>
                                </div>
                                <input type="text" name="phone" aria-label="Phone Number" class="form-control" placeholder="" value="{{$company->phone}}" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عنوان</span>
                                </div>
                                <input type="text" name="address" aria-label="Address" class="form-control" placeholder="" value="{{$company->address}}" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عنوان البريد الإلكتروني</span>
                                </div>
                                <input type="email" name="email" aria-label="Email Address" class="form-control" placeholder="irkforkf@f.com " value="{{$company->email}}" required>
                            </div>
                        </div>
                        <div class="form-group custom-btn" style="text-align:center;"> 
                            <button class="btn btn-success">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection

@section('js')
<script>
$('#uploadphotobutton').on('change',function(e){
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onloadend =function(){
            $('#uploadedphoto').attr('src',reader.result);    
        }
        reader.readAsDataURL(file);  
    })
    $('#preuploadphotobutton').on('click',function(){
        $('#uploadphotobutton').click();
    })
</script>
@endsection