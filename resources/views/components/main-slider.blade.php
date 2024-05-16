@php
    use App\Models\Question;
    use App\Models\QuestionStatistics;

    $slides = Question::getTopPopular();
@endphp

<div class="main_slider">
    @foreach ($slides as $slide)
        <div class="slide">
            <div class="bg">
                {{-- {{ dump($slide->file) }} --}}
                @php
                    $path = $slide->file ? Storage::url('questions/'.$slide->file->path) : Storage::url('main/no_photo.png');
                @endphp
                <img src="{{ $path }}" alt="" class="img-fluid rounded-start">
            </div>
            <div class="main">
                <div class="user">
                    <img src="{{ __('empty') }}" alt="">
                    <p>{{ $slide?->user?->name }}</p>
                </div>
                <blockquote>{{ mb_strlen($slide->title) > 60 ? mb_substr($slide->title, 0, 60) : $slide->title }}</blockquote>
                @if ($slide?->right_comment_id)
                    <div class="answer">
                        <div class="user">
                            <img src="{{ __('empty') }}" alt="">
                            <p>{{ $slide?->answer?->user->name }}</p>
                        </div>
                        <b>{{ mb_strlen($qslide?->answer->text) > 60 ? mb_substr($slide->answer->text, 0, 60) : $slide?->answer->text }}</b>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>