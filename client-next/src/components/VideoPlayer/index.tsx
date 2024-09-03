import { useState, useRef } from 'react'
import ReactPlayer from 'react-player'

function VideoPlayer({ video, caption }) {
  const [playing, setPlaying] = useState(false)
  const videoRef = useRef<HTMLInputElement>(null)

  console.log(caption)
  const handlePlay = event => {
    console.log('onPlay')
    setPlaying(true)
  }

  const handlePause = event => {
    console.log('onPause')
    setPlaying(false)
  }

  const handleProgress = value => {
    let played = value.played;
    let playedSeconds = value.playedSeconds;
    let loaded = value.loaded;
    let loadedSeconds = value.loadedSeconds;

    // const
    if (playedSeconds > 615) {
      videoRef.current.seekTo(0)
    }
  }

  return (
    <div className="video-player">
      <ReactPlayer
        ref={videoRef}
        url={video.src}
        controls
        playing={playing}
        onReady={() => console.log('onReady')}
        onStart={() => console.log('onStart')}
        onPlay={handlePlay}
        onPause={handlePause}
        onProgress={handleProgress}
      />

      {/*<video width="320" height="240" controls preload="none">
        <source src={video.src} type={video.src_type} />
        <source src={video.src_fallback} type={video.src_fallback_type} />
        <track
          src="/path/to/captions.vtt"
          kind="subtitles"
          srcLang="en"
          label="English"
        />
        Your browser does not support the video tag.
      </video>*/}
    </div>
  );
}

export default VideoPlayer;
