<html>
<body>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<video id="video" controls></video>
<script>
    if(Hls.isSupported())
    {
        {{$video}}
        var video = document.getElementById('video');
        var hls = new Hls();
        hls.loadSource({{$video}});
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED,function()
        {
            video.play();
        });
    }
    else if (video.canPlayType('application/vnd.apple.mpegurl'))
    {
        video.src = {{$video}};
        video.addEventListener('canplay',function()
        {
            video.play();
        });
    }
</script>
</body>
</html>
