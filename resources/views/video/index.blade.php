<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

    <title>Laravel File Upload</title>
    <style>
        .container {
            max-width: 500px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
        <h3 class="text-center mb-5">Upload File in Laravel</h3>
        @csrf
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="custom-file">
            <input type="file" name="video" class="custom-file-input" id="chooseFile">
            <label class="custom-file-label" for="chooseFile">Select file</label>
        </div>

        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
            Upload Files
        </button>
    </form>
</div>

<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mr-auto ml-auto mt-5">
    <h3 class="text-center">
        Videos
    </h3>

    @if(!empty($videos))
    @foreach($videos as $video)
            @if($video->stream_path)
        <div class="row mt-5">
            <div class="video" >
                <div class="title">
                    <input hidden id="src" value="{{'storage/'.$video->stream_path}}">

                    <h4>
                        <button onclick='player( "storage/{{$video->stream_path}}" )'>CLick Here To Play Video {{$video->original_name}}</button>
                    </h4>
                </div>

                <video id="video" controls style="display: none"></video>

            </div>
        </div>

            @endif

    @endforeach
    @endif
</div>

</body>
</html>

<script>
    function player(src) {
        if (Hls.isSupported()) {
            var video = document.getElementById('video');
            if (video.style.display === "none") {
                video.style.display = "block";
            } else {
                video.style.display = "none";
            }
         //   var src = document.getElementById('src').value;
            console.log(src);
            var hls = new Hls();
            hls.loadSource(src);
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                video.play();
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = src;
            video.addEventListener('canplay', function () {
                video.play();
            });
        }
    }
</script>
