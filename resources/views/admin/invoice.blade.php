@extends('admin.layout.default')


@section('content')
<div class="main-container">
    {{-- Tables --}}
    <div class="row">
        <!-- With Action-->
        <div class="col s12">
            <div class="card-panel">
                <div class="row box-title">
                    <div class="col s12">
                        <h5 class="content-headline">Company Table</h5>
                        <p>You can Delete.</p>
                    </div>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper">
                            <table class="datatable-badges display cell-border" style="text-align:center">
                                <thead>
                                <tr>
                                    <th>ID(PNR Number)</th>
                                    <th>Company Name</th>
                                    <th>Passenger Name</th>
                                    <th>Passenger Phone</th>
                                    <th>Travel Date</th>
                                    <th>Source</th>
                                    <th>Airline</th>
                                    <th>To pay</th>
                                    <th>Generator Name</th>
                                    <th>Cashier Name</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{$invoice->id }}</td>
                                            <td>{{$invoice->name }}</td>
                                            <td>{{$invoice->cname }}</td>
                                            <td>{{$invoice->phone }}</td>
                                            <td>{{$invoice->date_travel }}</td>
                                            <td>{{$invoice->source }}</td>
                                            <td>{{$invoice->airline }}</td>
                                            <td>{{$invoice->to_pay }}</td>
                                            <td>{{$invoice->generator }}</td>
                                            <td>{{$invoice->cashier }}</td>
                                            <td>{{Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/delinvoice/'.$invoice->id)}}">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')        

<script>
    $(document).ready(function() {
		$('select[name=DataTables_Table_0_length]').show();
	});
    $('.datatable-badges').DataTable({
        columnDefs: [{
            width: '5%',
            targets: [0]
        }, {
            width: '10%',
            targets: [1]
        }, {
            width: '10%',
            targets: [2]
        }, {
            width: '5%',
            targets: [3]
        }, {
            width: '5%',
            targets: [4]
        },{
            width: '10%',
            targets: [5]
        },{
            width: '10%',
            targets: [6]
        },{
            width: '10%',
            targets: [7]
        },{
            width: '10%',
            targets: [8]
        },{
            width: '10%',
            targets: [9]
        },{
            width: '10%',
            targets: [10]
        },{
            width: 'auto',
            targets: [11]
        }]
    });
</script>
@endsection
