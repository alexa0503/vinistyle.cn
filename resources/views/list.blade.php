<table class="myTable" width="100%">
    <tr id="tableNav">
      <td width="12%">排名</td>
      <td width="22%">姓名</td>
      <td width="16%">财富(亿元)</td>
      <td width="16%">财富变化</td>
      <td width="16%">财富来源</td>
      <td width="12%">居住地</td>
    </tr>
    @foreach ($list as $key=>$value)
    <tr @if ($value['isUser'] == true){!! 'class="first"'!!}@endif>
      <td>{{$key+1}}<img src="/images/@if ($value['scale'] > 0 ){{ 'up.png' }}@elseif ($value['scale'] < 0 ){{ 'down.png' }}@else{{'equal.png'}}@endif" /></td>
      <td>{{$value['name']}}</td>
      <td>{{$value['wealth']}}</td>
      <td>@if ($value['scale'] > 0 ){{ '+%' }}@elseif ($value['scale'] < 0 ){{ '-%' }}@endif{{abs($value['scale'])}}</td>
      <td>{{$value['from']}}</td>
      <td>{{$value['location']}}</td>
    </tr>
    @endforeach
</table>
