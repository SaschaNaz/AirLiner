<h1>Web Encoding System</h1>

User upload movie with subtitle in service.html.
If user click submit button, Send movie to upload.php.
Upload.php will start encoding automatically.
When finished encoding, Web browser automatically redirected to finished screen.
User can download encodded movie.

+ Should set timeout for long time. (ex. timeout = 1hour)
+ User must not turn off web browser.(User can't get encodded movie url)
+ If encoding fps(Frame Per Second) is higher than original movie fps, Mencoder may stopped before encoding.
+ MEncoder setted using NanumGothic font default. If you want to use other font, Change font option to other font in mp4convert file.
ㄴ How to download NanumGothic 

(IN CENTOS 6.3)
> wget http://static.campaign.naver.com/0/hangeul/renew/download/NanumFont_TTF.zip

> unzip NanumFont_TTF.zip

> mkdir /usr/share/fonts/nanum

> cp *.ttf /usr/share/fonts/nanum/

> fc-cache -r



License : BSD

Developer : Taylor Starfield - taylor@kloa.kr
