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
                    <span style="font-size: 20px;font-weight:bold;color:#6F6F6F;">{{$pp->id}}</span>
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
                    <span style="font-size:16px; font-weight:bold;">رقم الفاتورة</span>
                    <br/> 
                    <span style="font-size:16px;">{{$pp->invoice_nu}}</span>
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
                    <span style="font-size:16px; font-weight:bold;">ملاحظات  </span>
                    <span style="font-size:16px;">{{$pp->details}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td>
                    <span style="font-size:16px; font-weight:bold;">المبلغ</span>
                    <br/>
                    <span style="font-size:16px;">{{$pp->amount}}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table class="table-responsive" style="width:100%;border-collapse: collapse;color:#253858;">
        <tbody>
            <tr>
                <td>
                    <span style="font-size:16px; font-weight:bold;">مصدر الفاتورة</span>
                    <br/>
                    <span style="font-size:16px;">{{$employee->name}}</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>