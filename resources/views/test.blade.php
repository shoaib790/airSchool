
<html>
<body>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>


<video id="video" controls></video>
<input hidden id="src" value="http://as.test/storage/videos/uc15FaFSsX4y9WZRyHdlIxtECkEG1Bl8NE7SXte3.m3u8">

<script>
    if(Hls.isSupported())
    {
        var video = document.getElementById('video');
        var src = document.getElementById('src').value;
        console.log(src);
        var hls = new Hls();
        hls.loadSource(src);
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED,function()
        {
            video.play();
        });
    }
    else if (video.canPlayType('application/vnd.apple.mpegurl'))
    {
        video.src = src;
        video.addEventListener('canplay',function()
        {
            video.play();
        });
    }
</script>
</body>
</html>

