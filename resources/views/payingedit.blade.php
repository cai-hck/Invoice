@extends('layouts.app')

@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>صندوق فواتير تسديد المصادر</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form"   style="padding:60px;">
                    <form method="POST"  id="invoice_form" action="{{url('updatepaying')}}" name="invoice_form" class="" id="paid_form">
                        @csrf
                        <input type="hidden" value="{{$paying->id}}" name="id">
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم الوصل</span>
                                </div>
                                <input type="number" name="invoice_nu" aria-label="Invoice_nu" class="form-control" min="0" required  value="{{$paying->invoice_nu}}" >
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">المبلغ</span>
                                </div>
                                <input type="number" name="amount" aria-label="Total" class="form-control"  min="0" value="{{$paying->amount}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">المصدر</span>
                                </div>
                                <select name="u_company_id" class="form-control" style="height:68px">
                                <option value="{{$paying->u_company_id}}">{{$paying->source}} </option>
                                <?php foreach($sources as $source){?>
                                <option value="{{$source->id}}">{{$source->name}} </option>
                                <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">ملاحظات</span>
                                </div>
                                <input type="text" name="details"aria-label="Details" class="form-control" placeholder=""  value="{{$paying->details}}">
                            </div>
                        </div>
                        <div class="input-group form-group"  style="display:none;">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text"></span>
                                </div>
                                <input type="number" name="total" aria-label="Total" class="form-control" min="0" id="paid_money" value="{{$paying->total}}">
                            </div>
                        </div>
                        
                        <div class="input-group form-group" style="display:none">
                            <div class="returned-balance invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">أسترجاع الرصيد الى المسافر</span>
                                </div>
                                <input type="number" aria-label="Returned Passenger Balance" class="form-control" name="returned_balance_to_passenger" value="{{$paying->returned_balance_to_passenger}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="returned-balance invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">استرجاع الرصيد الى المصادر</span>
                                </div>
                                <input type="number" aria-label="Returned Balance from Source" class="form-control" name="returned_balance_from_source" value="{{$paying->returned_balance_from_source}}">
                            </div>
                        </div>
                        <div class="form-group custom-btn"> 
                            <button type="submit" id="buttonprint" class="btn btn-success">اصدار / طباعة</button>
                            <button type="submit" id="buttonsave" class="btn btn-success">اصدار / حفظ</button>
                            <button type="submit" id="buttonemail"class="btn btn-success">ارسال البريد الإلكتروني / حفظ</button>
                        </div>
                        <input type="hidden" id="modaltype" name="type">
                    </form>
                </div>
            </div>
        </div>
    </article>
</section>
<!-- Modal -->
<div class="modal fade" id="sendemailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header send-mail">
            <h5 class="modal-title" id="exampleModalScrollableTitle">إرسال إلى ايميل</h5>
        </div>
        <form class="modal-body text-center" id="sendemailform">
            <div class="model-logo">
                <img src="{{ asset('assets/images/logo.png')}}" alt="">
                <p>يرجى إدخال عنوان البريد الإلكتروني</p>
                <input class="form-control" type="email" placeholder="Email Address"id="pemail"required>
            </div>
            <div class="model-button">
                <button class="btn btn-send"> إرسال</button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#buttonprint').on('click',function(){
        $('#modaltype').val('print');
    })
    $('#buttonsave').on('click',function(){
        $('#modaltype').val('save');
    })
    $('#buttonemail').on('click',function(){ 
        $('#modaltype').val('email');
    })
    $('#invoice_form').submit(function(){
        if($('#modaltype').val() == 'email')
        {
            $('#sendemailmodal').modal();
            return false;
        }
        alert('تمت عملية الاصدار بنجاح  ');
        return true;
    })
    $('#sendemailform').submit(function(){
        $('#modaltype').val($('#pemail').val());
        $('#invoice_form').submit();
        return false;
    })
</script>
@endsection
