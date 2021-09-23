@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>قائمة الخطوط الجوية</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">اسم الخطوط الجوية</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                        </div>
                    </div>
                    <?php foreach($airlines as $airline){?>
                    <div class="input-group form-group"  style="padding-top:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$airline->name}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editairline/'.$airline->id)}}">تعديل</a>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delairline/'.$airline->id)}}">حذف</a>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
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