== I am getting a 500 when requesting /metrics ==

As usual, check your apache or php-fpm logs for the error. But if you see something like:

```
class APCIterator not found
```

you're missing the PHP APCu extension. Install it

== There are no cron metrics, and I am using cron from shell ==

APCu isn't shared between the CLI version of PHP and the mod_php or FPM versions (or any SAPIs). At this time, there
is no solution to this -- at some point, I will get around to persisting the metrics either on the filesystem
or in redis. Until then, you're out of luck!
