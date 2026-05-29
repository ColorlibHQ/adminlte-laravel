@extends('adminlte::page')

@section('title', 'Timeline')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Timeline</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">UI Elements</a></li>
                <li class="breadcrumb-item active" aria-current="page">Timeline</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Timeline example --}}
    <div class="row">
        <div class="col-md-12">
            {{-- The time line --}}
            <div class="timeline">
                {{-- timeline time label --}}
                <div class="time-label">
                    <span class="text-bg-danger">10 Feb. 2023</span>
                </div>
                {{-- /.timeline-label --}}
                {{-- timeline item --}}
                <div>
                    <i class="timeline-icon bi bi-envelope text-bg-primary"> </i>
                    <div class="timeline-item">
                        <span class="time"> <i class="bi bi-clock-fill"></i> 12:05 </span>
                        <h3 class="timeline-header">
                            <a href="#">Support Team</a> sent you an email
                        </h3>

                        <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning
                            heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo
                            edmodo ifttt zimbra. Babblely odeo kaboodle quora plaxo ideeli hulu weebly
                            balihoo...
                        </div>
                        <div class="timeline-footer">
                            <a class="btn btn-primary btn-sm">Read more</a>
                            <a class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>
                {{-- END timeline item --}}
                {{-- timeline item --}}
                <div>
                    <i class="timeline-icon bi bi-person text-bg-success"> </i>
                    <div class="timeline-item">
                        <span class="time"> <i class="bi bi-clock-fill"></i> 5 mins ago </span>
                        <h3 class="timeline-header no-border">
                            <a href="#">Sarah Young</a> accepted your friend request
                        </h3>
                    </div>
                </div>
                {{-- END timeline item --}}
                {{-- timeline item --}}
                <div>
                    <i class="timeline-icon bi bi-chat-text-fill text-bg-warning"> </i>
                    <div class="timeline-item">
                        <span class="time"> <i class="bi bi-clock-fill"></i> 27 mins ago </span>
                        <h3 class="timeline-header">
                            <a href="#">Jay White</a> commented on your post
                        </h3>
                        <div class="timeline-body">
                            Take me to your leader! Switzerland is small and neutral! We are more like
                            Germany, ambitious and misunderstood!
                        </div>
                        <div class="timeline-footer">
                            <a class="btn btn-warning btn-sm">View comment</a>
                        </div>
                    </div>
                </div>
                {{-- END timeline item --}}
                {{-- timeline time label --}}
                <div class="time-label">
                    <span class="text-bg-success">3 Jan. 2023</span>
                </div>
                {{-- /.timeline-label --}}
                {{-- timeline item --}}
                <div>
                    <i class="timeline-icon bi bi-camera text-bg-primary"> </i>
                    <div class="timeline-item">
                        <span class="time"> <i class="bi bi-clock-fill"></i> 2 days ago </span>
                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                        <div class="timeline-body">
                            <img src="{{ asset('vendor/adminlte/img/user1-128x128.jpg') }}" alt="..." />
                            <img src="{{ asset('vendor/adminlte/img/user1-128x128.jpg') }}" alt="..." />
                            <img src="{{ asset('vendor/adminlte/img/user1-128x128.jpg') }}" alt="..." />
                            <img src="{{ asset('vendor/adminlte/img/user1-128x128.jpg') }}" alt="..." />
                        </div>
                    </div>
                </div>
                {{-- END timeline item --}}
                {{-- timeline item --}}
                <div>
                    <i class="timeline-icon bi bi-camera-film text-bg-info"></i>

                    <div class="timeline-item">
                        <span class="time"> <i class="bi bi-clock-fill"></i> 5 days ago </span>

                        <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                        <div class="timeline-body">
                            <div class="ratio ratio-16x9">
                                <iframe
                                    src="https://www.youtube.com/embed/tMWkeBIohBs"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                        <div class="timeline-footer">
                            <a href="#" class="btn btn-sm text-bg-warning"> See comments </a>
                        </div>
                    </div>
                </div>
                {{-- END timeline item --}}
                <div>
                    <i class="timeline-icon bi bi-clock-fill text-bg-secondary"> </i>
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@stop
