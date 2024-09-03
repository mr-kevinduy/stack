'use client'

import { useState, useEffect } from 'react'
import VideoPlayer from '@/components/VideoPlayer'
import { videos, captions } from '@/data/video'

export default function VideoDetailPage({
  params: { id },
}: {
  params: { id: string|number }
}) {
  const video = videos.find(val => val.id == id);
  const caption = captions.find(val => val.video_id == id);
  const [isClient, setIsClient] = useState(false)

  useEffect(() => {
    setIsClient(true)
  }, [])

  return (
    <div className="video-detail-page">
      <div className="container mx-auto py-8">
        <h2>{video.title}</h2>

        { isClient ?
          <VideoPlayer
            video={video}
            caption={caption}
          /> : null }
      </div>
    </div>
  );
}
