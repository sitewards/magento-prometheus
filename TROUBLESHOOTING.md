== I am getting a 500 when requesting /metrics ==

As usual, check your apache or php-fpm logs for the error. But if you see something like:

```
class APCIterator not found
``` 

you're missing the PHP APCu extension. Install it
