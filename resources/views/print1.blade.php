<html>
    
<?php  
$path_image1 = public_path('/upload/logo/');
$path_image2 = public_path('/upload/qr/');?>
<head>
    <!--title-->
    <title>Home-Table</title>
    <!--end of title-->

    <!--meta-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--end of meta-->
</head>

<body style="margin:0px; padding:0px;">

<div class="maindiv" style="width:100%; margin: auto; background-color:#FBFCFD; padding: 0px 15px;">
    <table class="table-responsive" style="width:100%;border-collapse: collapse;">
        <tbody>
            <tr>
                <td style=" text-align:right; padding-bottom: 5px; width:70%;"> 
                    <img src="{{$path_image1.$company->photo}}" style=" width:130px;">
                </td>
                <td style=" text-align:left;  width:30%;">
                    <span style="font-size: 12px;color:#253858;"><?php echo Date('d/m/Y');?></span><br/>
                    <span style="font-size: 16px;font-weight:bold;color:#6F6F6F;">رقم الفاتورة</span><br/>
                    <span style="font-size: 20px;font-weight:bold;color:#6F6F6F;">{{$invoice->id}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="background-color:#D7D7D7;height:2px;width:100%;text-align:center;">
    </div>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td style="width:50%;">
                    <span style="font-size:16px; font-weight:bold;">اسم المسافر</span>
                    <br/> 
                    <span style="font-size:16px;">{{$invoice->name}}</span>
                </td>
                <td style="width:50%;text-align:left;">
                    <img src="{{$path_image2.$qr}}" style="width:130px;">
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td>
                    <span style="font-size:16px; font-weight:bold;">التفاصيل  </span>
                    <span style="font-size:16px;">{{$invoice->details}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>   
    <table class="table-responsive" style="width:60%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold;">عدد البالغين</span>
                    <br/> 
                    <span style="font-size:14px;">{{$invoice->adult_no}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold;">سعر الشراء</span>
                    <br/> 
                    <span style="font-size:14px;">${{$invoice->adult_buy}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold; ">سعر البيع</span>
                    <br/> 
                    <span style="font-size:14px;">${{$invoice->adult_sell}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold; ">سعر الفير</span>
                    <br/> 
                    <span style="font-size:14px;">${{$invoice->adult_fair}}</span>
                </td>
            </tr>
            <tr>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold;">عدد الأطفال</span>
                    <br/> 
                    <span style="font-size:12px;">{{$invoice->child_no}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold;">سعر الشراء</span>
                    <br/> 
                    <span style="font-size:12px;">${{$invoice->child_buy}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold; ">سعر البيع</span>
                    <br/> 
                    <span style="font-size:12px;">${{$invoice->child_sell}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold; ">سعر الفير</span>
                    <br/> 
                    <span style="font-size:12px;">${{$invoice->child_fair}}</span>
                </td>
            </tr>
            <tr>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold;">عدد الرضع</span>
                    <br/> 
                    <span style="font-size:12px;">{{$invoice->infant_no}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold;">سعر الشراء</span>
                    <br/> 
                    <span style="font-size:12px;">${{$invoice->infant_buy}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:14px; font-weight:bold; ">سعر البيع</span>
                    <br/> 
                    <span style="font-size:12px;">${{$invoice->infant_sell}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td>
                    <span style="font-size:16px; font-weight:bold;">المصدر  </span>
                    <span style="font-size:16px;">{{$source->name}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td style="width:15%;">
                    <span style="font-size:16px; font-weight:bold; ">الصندوق </span>
                    <br/> 
                    <span style="font-size:12px;">{{$invoice->paid}}</span>
                </td>
                <td style="width:15%;">
                    <span style="font-size:16px; font-weight:bold; ">باقي</span>
                    <br/> 
                    <span style="font-size:12px;">{{$invoice->to_pay-$invoice->paid}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td style="width:50%;">
                    <span style="font-size:16px; font-weight:bold; ">عمولة المصدر%</span>
                    <br/> 
                    <span style="font-size:12px;">{{$invoice->comission_source}}%</span>
                </td>
                <td style="width:50%;">
                    <span style="font-size:16px; font-weight:bold; ">أرباح المسافر</span>
                    <br/> 
                    <span style="font-size:12px;">{{($invoice->adult_no*$invoice->adult_sell+$invoice->child_no*$invoice->child_sell+$invoice->infant_no*$invoice->infant_sell)*$invoice->comission_passenger}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td style="width:50%;">
                    <span style="font-size:16px; font-weight:bold; ">أسترجاع الرصيد من المصدر</span>
                    <br/> 
                    <span style="font-size:12px;">0</span>
                </td>
                <td style="width:50%;">
                    <span style="font-size:16px; font-weight:bold; ">أسترجاع الرصيد الى المسافر</span>
                    <br/> 
                    <span style="font-size:12px;">0</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>