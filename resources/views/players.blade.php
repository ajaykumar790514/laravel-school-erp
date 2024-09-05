<?php //print_r(getPlayers(10));exit;?>
<table>
    <tr>
       @for ($x = 1; $x <= 11; $x++) 
        <th>Team {{$x}}</th>
      @endfor
    </tr>
        <tr>
             @for ($k = 1; $k <= 11; $k++) 
                    <td> @foreach(getPlayers(11) as $team1)
                            {{ $team1->name}}<br>
                         @endforeach
                        </td>
            @endfor
        </tr>
</table>
