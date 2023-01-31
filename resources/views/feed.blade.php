<?xml version='1.0' encoding='UTF-8'?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom">
      <channel>
        <atom:link href="http://fpn.fantata/feeds/{{$show->id}}" rel="self" type="application/rss+xml"/>
        <title>{{$show->title}}</title>
        <link>http://fpn.fantata/shows/{{$show->id}}</link>
        <pubDate>Fri, 11 Feb 2022 22:10:01 +0000</pubDate>
        <lastBuildDate>Fri, 11 Feb 2022 22:10:01 +0000</lastBuildDate>
        <ttl>60</ttl>
        <language>en</language>
        <copyright>All rights reserved</copyright>
        <webMaster>feeds@fantata.com (Fantata Podcast Network Feeds)</webMaster>
        <description>Podcast</description>
        <itunes:subtitle>Podcast</itunes:subtitle>
        <itunes:owner>
          <itunes:name>{{$show->title}}</itunes:name>
          <itunes:email>{{$show->user->email}}</itunes:email>
        </itunes:owner>
        <itunes:author>{{$show->user->name}}</itunes:author>
        <itunes:explicit>{{$show->explicit ? 'yes' : 'no'}}</itunes:explicit>
        <itunes:image href="http://fpn.fantata/covers/show/{{$show->id}}"/>
        <image>
          <url>http://fpn.fantata/covers/show/{{$show->id}}</url>
          <title>{{$show->title}}</title>
          <link>http://fpn.fantata/shows/{{$show->id}}</link>
        </image>
        <itunes:category text="{{$show->category->name}}"/>

        @foreach($show->episodes as $episode)
            <item>
            <guid isPermaLink="false">fpn:{{$episode->id}}</guid>
            <title>{{$episode->title}}</title>
            <pubDate>Sun, 10 May 2020 14:11:39 +0000</pubDate>
            <link>http://fpn.fantata/show/{{$show->id}}/{{$episode->id}}</link>
            <itunes:duration>{{$episode->duration}}</itunes:duration>
            <itunes:author>{{$show->user->name}}</itunes:author>
            <itunes:explicit>{{$episode->explicit ? 'yes' : 'no'}}</itunes:explicit>
            <itunes:summary>{{$episode->description}}</itunes:summary>
            <itunes:subtitle>{{$episode->subtitle}}</itunes:subtitle>
            <description>{{$episode->description}}</description>
            <enclosure type="audio/mpeg" url="http://fpn.fantata/episode/{{$episode->id}}" length="{{$episode->bytes}}"/>
            <itunes:image href="http://fpn.fantata/covers/episode/{{$episode->id}}"/>
            </item>
        @endforeach

      </channel>
    </rss>