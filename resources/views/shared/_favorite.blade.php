<form id="favorite-{{$name}}-{{ $model->id }}" action="/{{ $firstURISegment }}/{{ $model->id }}/favorites" method="post" style="display: none;">
    @csrf
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>
