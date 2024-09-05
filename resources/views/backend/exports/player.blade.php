<?php //print_r(getPlayers(10));exit;?>
<table>
    <tr>
       @for ($x = 1; $x <= 100; $x++) 
        <th>Team {{$x}}</th>
      @endfor
    </tr>
        <tr>
             @for ($k = 1; $k <= 100; $k++) 
             <?php $flagCaption=0;?>
                    <td> @foreach(getPlayers(11) as $team1)
                        @if($team1->cpaton==1)   
                           <?php $flagCaption++; ?>
                            @if($flagCaption==1)
                                {{ strtoupper($team1->name)}}
                            @else
                                {{ strtolower($team1->name)}}
                            @endif
                        @else   
                            {{ strtolower($team1->name)}}
                        @endif
                        <br>
                         @endforeach
                        </td>
            @endfor
        </tr>
</table>
