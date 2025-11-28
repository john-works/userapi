
@if($outOfOffice->expired == 1) @else <a class="btnDeleteAjax" data-url="{{route('out-of-office.remove',encrypt($outOfOffice->id))}}" href="#">Remove</a> @endif