@props(['user'])

@if($user && $user->badges->count() > 0)
    <span class="ms-1">
        @foreach($user->badges as $badge)
            <span class="badge rounded-pill bg-warning text-dark" title="{{ $badge->description }}">
                {{ $badge->icon }}
            </span>
        @endforeach
    </span>
@endif