@extends('layouts.app')

@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>اضافة فاتورة مصاريف</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form" style="padding:60px;">
                    <form method="POST" action="{{url('newexpense')}}" name="invoice_form" class="" id="paid_form">
                        @csrf
                        <div class="input-group form-group d-flex date-no">
                            <div class="invoice-travel-date invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">التاريخ</span>
                                </div>
                                <input type="text"  aria-label="Date" class="form-control" placeholder="" value="<?php echo date('d/m/Y');?>"  style="max-width:100%" readonly>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم المستلم</span>
                                </div>
                                <input type="text" name="name"aria-label="Name" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">ملاحظات</span>
                                </div>
                                <input type="text" name="note"aria-label="Note" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">المبلغ</span>
                                </div>
                                <input type="number" name="cost"aria-label="Cost" class="form-control" value="0" min="0" id="paid_money">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">التفاصيل</span>
                                </div>
                                <input type="text" name="details"aria-label="Detail" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group custom-btn"> 
                            <button type="submit" class="btn btn-success" id="paid_form_button" >إضافة / طباعة</button>
                        </div>
                        <input type="hidden" name="type" id="formtype">
                    </form>
                </div>
            </div>
        </div>
    </article>
</section>
<!-- Modal -->
<div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">يرجى تأكيد استقطاع الرصيد من الأرباح النهائية</h5>
            </div>
            <div class="modal-body text-center">
                <div class="model-logo">
                    <input class="form-control" type="text" readonly id="confirm_paid_money" style="text-align: center;">
                </div>
                <div class="model-button">
                    <button class="btn btn-success" id="confirm_modal"> تأكيد / طباعة</button>
                    <button class="btn btn-success" id="confirm_modal1">اصدار / حفظ</button>
                    <button class="btn btn-success" id="confirm_modal2">ارسال البريد الإلكتروني / حفظ</button>
                    <button class="btn btn-danger" id="cancel_modal"> إلغاء</button>
                </div>
            </div>
        </div>
    </div>
</div>
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
<input type="hidden" value="0" id="formstatus">
@endsection
@section('js')
<script>
    $('#paid_form_button').on('click',function(){
        $('#confirm_paid_money').val($('#paid_money').val());
    })
    $('#paid_form').submit(function(){
        if($('#formstatus').val() == '0')
        {
            $('#confirmmodal').modal();
            return false;
        }
        alert('تمت عملية الاصدار بنجاح  ');
        if($('#modaltype').val() == 'print')
        {
            setTimeout(function() { window.location = $('#addexpense_a').prop('href'); }, 2000);
        }
        return true;
    })
    $('#confirm_modal').on('click',function(){
        $('#formstatus').val('1');
        $('#formtype').val('print');
        $('#paid_form').submit();
    })
    $('#confirm_modal1').on('click',function(){
        $('#formstatus').val('1');
        $('#formtype').val('save');
        $('#paid_form').submit();
    })
    $('#confirm_modal2').on('click',function(){
        $('#confirmmodal').modal('toggle');
        $('#sendemailmodal').modal();
    })
    $('#sendemailform').submit(function(){
        $('#formstatus').val('1');
        $('#formtype').val($('#pemail').val());
        $('#paid_form').submit();
        return false;
    })
    $('#cancel_modal').on('click',function(){
        $('#confirmmodal').modal('toggle');
    })
</script>
@endsection
