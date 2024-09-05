<table> 
    <tr>
        <th colspan='28' style="text-align: center; font-weight: bold; font-size:20px">{{getsiteTitle()}}</th>
    </tr>
    <tr>
        <th colspan='28' style="text-align: center; font-weight: bold;">{{getaddress()}} </th>
    </tr>
    <tr>
        <th colspan='9' style="text-align: center; font-weight: bold;">Class Teacher : {{$teacher}} </th>
        <th colspan='9' style="text-align: center; font-weight: bold;">Fee Report : {{$sessionName}}</th>
        <th colspan='9' style="text-align: center; font-weight: bold;">Class : {{$className}}({{$sectionName}})</th>
    </tr>
    <tr>
        <th style="text-align: center; font-weight: bold;">Sr. No.</th>
        <th style="text-align: center; font-weight: bold;">Name</th>
        @foreach(getMonths() as $month)
        <th style="text-align: center; font-weight: bold;">{{$month->month_name}}</th>
        <th style="text-align: center; font-weight: bold;">Section</th>
        @endforeach
        <th style="text-align: center; font-weight: bold;">Total</th>
        <th style="text-align: center; font-weight: bold;">Discount</th>
        <th style="text-align: center; font-weight: bold;">Old Balance</th>
        <th style="text-align: center; font-weight: bold;">Paid Amount</th>
         <th style="text-align: center; font-weight: bold;">Balance</th>
    </tr><?php $i=1;
            $totalAmt=0
        ?>
        @foreach($data as $dataDetails)
            <tr role="row">
             <td>{{$i}}</td>
             <td>{{$dataDetails->student_name}}</td>
            @foreach(getMonths() as $month)
                <td>{{$total=getFeeCollectionByMonthStudent($sessionID, $classID, $dataDetails->sectionsetup_id, $dataDetails->id, $month->id)}}</td>
                <td>{{$total==0?"":getSectionByMonthStudent($sessionID, $classID, $dataDetails->id, $month->id)}}</td>
            <?php $totalAmt=$totalAmt+$total;?>
            @endforeach
            <td>{{$totalAmt}}</td>
            <td>{{getFeeOldBalanceStudent($sessionID, $classID, $dataDetails->id)}}</td>
            <td>{{getDiscountByStudent($sessionID, $classID, $dataDetails->id)}}</td>
            <td>{{getPaidAmtByStudent($sessionID, $classID, $dataDetails->id)}}</td>
            <td>{{getTotalBalance($sessionID, $classID, $dataDetails->sectionsetup_id, $dataDetails->id)}}</td>
            </tr>
            
            <?php $i++;
            $totalAmt=0;?>
        @endforeach
        
</table>