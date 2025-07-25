@foreach ($works as $work)
    @include('partials._work_card', ['work' => $work])
@endforeach
