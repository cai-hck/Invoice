@extends('layouts.app')

@section('css')

@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>المستخدمين</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <form  action="{{url('updateuser')}}" method="POST" enctype="multipart/form-data" name="invoice_form" class="" id="invoice_form" >
                        @csrf
                        <input type="hidden" name="id" value="{{$employee->id}}">
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم</span>
                                </div>
                                <input type="text" name="name" aria-label="Name" class="form-control" placeholder="" required value="{{$employee->name}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">التعليم</span>
                                </div>
                                <input type="text" name="education" aria-label="Education" class="form-control" placeholder="" required value="{{$employee->education}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">التخصص</span>
                                </div>
                                <input type="text" name="specilized" aria-label="Specilized" class="form-control" placeholder="" required value="{{$employee->specilized}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عنوان البريد الإلكتروني</span>
                                </div>
                                <input type="email" name="email" aria-label="Email Address" class="form-control" placeholder="" required value="{{$employee->email}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم الهاتف</span>
                                </div>
                                <input type="text" name="phone" aria-label="Phone Number" class="form-control" placeholder="" required value="{{$employee->phone}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عنوان</span>
                                </div>
                                <input type="text" name="address" aria-label="Address" class="form-control" placeholder="" required value="{{$employee->address}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">ملاحظات</span>
                                </div>
                                <input type="text" name="note" aria-label="Notes" class="form-control" placeholder=""required value="{{$employee->note}}">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">كلمه السر(اختياري)</span>
                                </div>
                                <input type="password" id="myFunction1" name="password" aria-label="Password" class="form-control" placeholder="" autocomplete="new-password">

                                <div  onclick="myFunction1()" style="    padding-top: 15px;">
                                    <img src="{{ asset('assets/images/eye-show.svg')}}" alt="..." class="InputIcon iconRight" style="left: 20px;right: auto;width: 50px;">
                                </div>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تصدير الفاتورة</span>
                                </div>
                                <input type="checkbox" name="generator" aria-label="Generator" class="form-control" placeholder="" value="1" <?php if($employee->generator == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تعديل الفاتورة</span>
                                </div>
                                <input type="checkbox" name="edit_invoices" aria-label="Edit Invoices" class="form-control" placeholder="" value="1" <?php if($employee->edit_invoices == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">حذف فاتورة</span>
                                </div>
                                <input type="checkbox" name="delete_invoices" aria-label="Delete Invoices" class="form-control" placeholder="" value="1" <?php if($employee->delete_invoices == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">جميع الفواتير</span>
                                </div>
                                <input type="checkbox" name="see_allinvoices" aria-label="Check All Invoices" class="form-control" placeholder="" value="1" <?php if($employee->see_allinvoices == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الصندوق</span>
                                </div>
                                <input type="checkbox" name="cashier" aria-label="Cashier" class="form-control" placeholder="" value="1" <?php if($employee->cashier == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اضافة مصاريف</span>
                                </div>
                                <input type="checkbox" name="expenser" aria-label="Expenser" class="form-control" placeholder="" value="1" <?php if($employee->expenser == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تعديل المصاريف</span>
                                </div>
                                <input type="checkbox" name="edit_expenses" aria-label="Edit Expenses" class="form-control" placeholder="" value="1" <?php if($employee->edit_expenses == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">حذف مصاريف</span>
                                </div>
                                <input type="checkbox" name="delete_expenses" aria-label="Delete Invoices" class="form-control" placeholder="" value="1" <?php if($employee->delete_expenses == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">جميع المصاريف</span>
                                </div>
                                <input type="checkbox" name="see_allexpenses" aria-label="Check All Expenses" class="form-control" placeholder="" value="1" <?php if($employee->see_allexpenses == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">انشاء فاتورة الشرككات</span>
                                </div>
                                <input type="checkbox" name="generator1" aria-label="Generator1" class="form-control" placeholder="" value="1" <?php if($employee->generator1 == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تعديل فاتورة المستفيد</span>
                                </div>
                                <input type="checkbox" name="edit_invoice1s" aria-label="Edit Invoice1s" class="form-control" placeholder="" value="1" <?php if($employee->edit_invoice1s == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">حذف فاتورة المستفيد</span>
                                </div>
                                <input type="checkbox" name="delete_invoice1s" aria-label="Delete Invoice1s" class="form-control" placeholder="" value="1" <?php if($employee->delete_invoice1s == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الاطلاع على جميع الفواتير</span>
                                </div>
                                <input type="checkbox" name="see_allinvoice1s" aria-label="Check All Invoice1s" class="form-control" placeholder="" value="1" <?php if($employee->see_allinvoice1s == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">انشاء فاتورة تسديد شركات</span>
                                </div>
                                <input type="checkbox" name="paying" aria-label="Paying" class="form-control" placeholder="" value="1" <?php if($employee->paying == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تعديل فاتورة تسديد الشركات</span>
                                </div>
                                <input type="checkbox" name="edit_payings" aria-label="Edit Payings" class="form-control" placeholder="" value="1" <?php if($employee->edit_payings == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">حذف فاتورة تسديد الشركات</span>
                                </div>
                                <input type="checkbox" name="delete_payings" aria-label="Delete Payings" class="form-control" placeholder="" value="1" <?php if($employee->delete_payings == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الاطلاع على فاتورة تسديد الشركات</span>
                                </div>
                                <input type="checkbox" name="see_allpayings" aria-label="Check All Payings" class="form-control" placeholder="" value="1" <?php if($employee->see_allpayings == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">انشاء فاتورة الشركات</span>
                                </div>
                                <input type="checkbox" name="paid" aria-label="Paid" class="form-control" placeholder="" value="1" <?php if($employee->paid == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تعديل فاتورة  الشركات</span>
                                </div>
                                <input type="checkbox" name="edit_paids" aria-label="Edit Paids" class="form-control" placeholder="" value="1" <?php if($employee->edit_paids == '1'){echo 'checked';}?>> 
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">حذف فاتورة  الشركات</span>
                                </div>
                                <input type="checkbox" name="delete_paids" aria-label="Delete Paids" class="form-control" placeholder="" value="1" <?php if($employee->delete_paids == '1'){echo 'checked';}?>>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الاطلاع على فاتورة  الشركات</span>
                                </div>
                                <input type="checkbox" name="see_allpaids" aria-label="Check All Paids" class="form-control" placeholder="" value="1" <?php if($employee->see_allpaids == '1'){echo 'checked';}?>>
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
function myFunction1() {
  var x = document.getElementById("myFunction1");
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
}
function myFunction2() {
  var x = document.getElementById("myFunction2");
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
}
</script>
@endsection