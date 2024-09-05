<table>
    <tr>
        <th colspan='11' style="text-align: center; font-weight: bold;"> Date wise Fee collection Record from {{$fromDate}} to {{$toDate}} </th>
    </tr>
    <tr>
        <th style="text-align: center; font-weight: bold;">Receipt No.</th>
        <th style="text-align: center; font-weight: bold;">Receipt Date</th>
        <th style="text-align: center; font-weight: bold;">Class</th>
        @foreach(getFeeHead() as $feeHead)
            <th style="text-align: center; font-weight: bold;">{{$feeHead->fee_head_name}}</th>
        @endforeach
        <th style="text-align: center; font-weight: bold;">Concession</th>
        <th style="text-align: center; font-weight: bold;">Total</th>
    </tr><?php $totalHeandAmt=0;?>
        @foreach($data as $dataDetails)
        <?php $invoiceID=base64_encode($dataDetails->invoice_no);?>
            <tr role="row">
             <td>{{$dataDetails->receipt_no}}</td>
             <td>{{date('d F Y', strtotime($dataDetails->receipt_date))}}</td>
             <td>{{$dataDetails->class_name}}</td>
             @foreach(getFeeHead() as $feeHead)
                <td style="text-align: center; font-weight: bold;">
                    {{$totalHeand=getFeeCollectionByFeeHead($dataDetails->session_id, 
                    $dataDetails->class_id, $dataDetails->section_id, 
                    $feeHead->id,  $dataDetails->invoice_no)}}
                    <?php $totalHeandAmt=$totalHeandAmt+$totalHeand;?>
                </td>
             @endforeach
             <td>{{$dataDetails->discount}}</td>
            <td>{{$totalHeandAmt}}</td>
            </tr>
            <?php $totalHeandAmt=0;?>
        @endforeach 
</table>