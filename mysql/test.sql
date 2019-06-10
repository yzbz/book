SELECT * FROM
(SELECT ID,(@i:=@i+1) AS i FROM sps_posts,(SELECT @i:=0) AS it WHERE post_status='publish') temp
