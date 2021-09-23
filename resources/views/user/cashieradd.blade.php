@extends('layouts.app')

@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>الصندوق</h4>
            <div class="new-invoice-inner">
                <div class="search-block" >
                    <form method="POST" action="{{url('findinvoice')}}" name="search_form" class="search-form" id="search_form_cashier">
                        @csrf
                        <input type="text" name="id" placeholder="رقم الفاتورة" name="search">
                        <input type="text" name="passport" placeholder="PRN/Passport" name="search">
                        <button type="submit" style="margin-right: 10px;">بحث <i class="fa fa-search"></i></button>
                    </form>
                </div>
                <?php if($invoice != ''){?>
                <div class="invoice-form" style="padding:60px;">
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">رقم الفاتورة</span>
                            </div>
                            <input type="text" aria-label="Reference Number" class="form-control" placeholder="" readonly value="{{$invoice->id}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">اسم الشخص</span>
                            </div>
                            <input type="text" aria-label="Name of passenger" class="form-control" placeholder="" readonly value="{{$invoice->name}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">مصدر الفاتورة</span>
                            </div>
                            <input type="text" aria-label="Issued by" class="form-control" placeholder="" readonly value="{{$invoice->generator}}">
                        </div>
                    </div>
                </div>
                <div class="invoice-form" style="    border-top: 5px solid #e8e8e8;padding:60px;">
                    <form method="POST" action="{{url('newcashier')}}" name="invoice_form" class="" id="paid_form">
                        @csrf
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">باقي  </span>
                                </div>
                                <input type="number" name="paid"aria-label="Payment Recieved" class="form-control" value="0" min="0" id="paid_money">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الصندوق   </span>
                                </div>
                                <input type="number" aria-label="balance" class="form-control" value="{{$invoice->to_pay - $invoice->paid}}" min="0" id="balance_money" readonly>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$invoice->id}}">
                        <div class="form-group custom-btn"> 
                            <button type="button" class="btn btn-success" data-toggle="modal" id="paid_form_button" data-target="#confirmmodal">تأكيد </button>
                        </div>
                        <input type="hidden" value="save" name="type" id="paid_type">
                    </form>
                </div>
                <input type="number" value="{{$invoice->to_pay - $invoice->paid}}" id="to_pay_money" style="display:none">
                <?php }?>
            </div>
        </div>
    </article>
</section>
<!-- Modal -->
<div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">يرجى تأكيد المبلغ المستلم</h5>
            </div>
            <div class="modal-body text-center">
                <div class="model-logo">
                    <input class="form-control" type="text" readonly id="confirm_paid_money" style="text-align: center;">
                </div>
                <div class="model-button">
                    <button class="btn btn-success" id="confirm_modal_print"> تأكيد  / طباعة</button>
                    <button class="btn btn-success" id="confirm_modal"> تأكيد  </button>
                    <button class="btn btn-danger" id="cancel_modal"> إلغاء</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#paid_money').on('input',function(){
        $('#balance_money').val( parseInt($('#to_pay_money').val()) - parseInt($('#paid_money').val()));
    })
    $('#paid_form_button').on('click',function(){
        $('#confirm_paid_money').val($('#paid_money').val());
    })
    $('#confirm_modal').on('click',function(){
        $('#paid_form').submit();
    })
    $('#confirm_modal_print').on('click',function(){
        $('#paid_type').val('print');
        $('#paid_form').submit();
        setTimeout(function() { window.location = $('#addcashier_a').prop('href'); }, 2000);
    })
    $('#cancel_modal').on('click',function(){
        $('#confirmmodal').modal('toggle');
    })
</script>
@endsection
