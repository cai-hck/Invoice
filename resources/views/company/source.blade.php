@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>قائمة المصادر</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">اسم المصدر</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">عنوان البريد الإلكتروني</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم الهاتف</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                        </div>
                    </div>
                    <?php foreach($sources as $source){?>
                    <div class="input-group form-group"  style="padding-top:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$source->name}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$source->email}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$source->phone}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editsource/'.$source->id)}}">تعديل</a>
                                <a class="btn btn-danger" style="width:50%"onclick="return confirm('قم بتأكيد الحذف?')"  href="{{ url('/delsource/'.$source->id)}}">حذف</a>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection

@section('js')
<script>

</script>
@endsection