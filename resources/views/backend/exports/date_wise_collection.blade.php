<table>
    <tr>
        <th colspan='11' style="text-align: center; font-weight: bold;"> Date wise Fee collection Record from {{$fromDate}} to {{$toDate}} </th>
    </tr>
    <tr>
        <th style="text-align: center; font-weight: bold;">Receipt No.</th>
        <th style="text-align: center; font-weight: bold;">Receipt Date</th>
        <th style="text-align: center; font-weight: bold;">Name</th>
        <th style="text-align: center; font-weight: bold;">Father Name</th>
        <th style="text-align: center; font-weight: bold;">Class</th>
        <th style="text-align: center; font-weight: bold;">Section</th>
        <th style="text-align: center; font-weight: bold;">Total Amount</th>
        <th style="text-align: center; font-weight: bold;">Received Amount</th>
        <th style="text-align: center; font-weight: bold;">Balance</th>
        <th style="text-align: center; font-weight: bold;">Received By</th>
    </tr>
        @foreach($data as $dataDetails)
        <?php $invoiceID=base64_encode($dataDetails->invoice_no);?>
            <tr role="row">
             <td>{{$dataDetails->receipt_no}}</td>
             <td>{{date('d F Y', strtotime($dataDetails->receipt_date))}}</td>
             <td>{{$dataDetails->student_name}}</td>
             <td>{{$dataDetails->father_name}}</td> 
             <td>{{$dataDetails->class_name}}</td>
             <td>{{$dataDetails->section_name}}</td>
             <td>{{$dataDetails->grand_total}}</td>
             <td>{{$dataDetails->payed_amt}}</td>
             <td>{{$dataDetails->curent_balance}}</td>
            <td>{{$dataDetails->name}}</td>
            </tr>
        @endforeach 
        <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th style="text-align: center; font-weight: bold;">{{$sum_payed_amt}}</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
</table>