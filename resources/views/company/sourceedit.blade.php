@extends('layouts.app')

@section('css')

@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>قائمة المصادر</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <form  action="{{url('updatesource')}}" method="POST" enctype="multipart/form-data" name="invoice_form" class="" id="invoice_form" >
                        @csrf
                        <input type="hidden" name="id" value="{{$source->id}}"> 
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم المصدر</span>
                                </div>
                                <input type="text" name="name" aria-label="Name" class="form-control" placeholder="" required  value="{{$source->name}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عنوان البريد الإلكتروني</span>
                                </div>
                                <input type="email" name="email" aria-label="Email Address" class="form-control" placeholder="" required  value="{{$source->email}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم الهاتف</span>
                                </div>
                                <input type="text" name="phone" aria-label="Phone Number" class="form-control" placeholder="" required  value="{{$source->phone}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عنوان</span>
                                </div>
                                <input type="text" name="address" aria-label="Address" class="form-control" placeholder="" required  value="{{$source->address}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">ملاحظات</span>
                                </div>
                                <input type="text" name="note" aria-label="Notes" class="form-control" placeholder=""required  value="{{$source->note}}">
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

</script>
@endsection