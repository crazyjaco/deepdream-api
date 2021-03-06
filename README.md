deepdream-api
-------------
REST API interface for generating [deep dream images](https://photos.google.com/share/AF1QipPX0SCl7OzWilt9LnuQliattX4OUCj_8EP65_cTVnBmS1jnYgsGQAieQUc1VQWdgQ?key=aVBxWjhwSzg2RjJWLWRuVFBBZEN1d205bUdEMnhB)

The deep dream dependency installation script compiles caffe to run in CPU mode as opposed to GPU. You might want to change this configuration so you get better speed when generating images, thus faster API calls. Also, for performance hardware information check this [link](http://caffe.berkeleyvision.org/performance_hardware.html) out.

WORK IN PROGRESS

### Add image to dream queue

```
ubuntu@ubuntu:~$ curl -s -X POST -F "upload=@/home/ubuntu/images/kitty.jpg" http://localhost/upload
{
    "dc4c71d79843a261cae70486a0f0b54a": {
        "status": "queued",
        "dream_url": "http:\/\/localhost\/dream\/dc4c71d79843a261cae70486a0f0b54a",
        "uploaded": 1437542491,
        "file_type": "jpg",
        "file_size": 89071,
        "file_orig": "http:\/\/localhost\/uploads\/kitty.jpg",
        "file_name": "uploads\/kitty.jpg"
    }
}
```

![dreamy cat](http://i.imgur.com/vJU61Yy.jpg)

![giraffe](http://i.imgur.com/vUbcxaq.jpg)
