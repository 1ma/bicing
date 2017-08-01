# Bicing

See Bicing stations occupancy levels over time.

![screenshot]


## Development

### Requirements

* [Docker Engine] >= 1.10
* [Docker Compose] >= 1.8
* [Composer] >= 1.0


### Setting Up

1. Run `composer up` inside the project directory.
2. Find yourself a [Google API Key] and fill it in at the `app/settings.php` configuration file.
3. In your `/etc/hosts` file, map `bicing.local` to either `localhost` or your docker-machine's IP, depending on your Docker setup.
4. Visit `https://bicing.local` on your browser. The HTTPS warning is expected as the development webserver uses a self-signed certificate.


[screenshot]: http://i.imgur.com/rtXZ8C4.png
[Docker Engine]: https://docs.docker.com/engine/installation/linux/docker-ce/ubuntu/
[Docker Compose]: https://github.com/docker/compose/releases
[Composer]: https://getcomposer.org/
[Google API Key]: https://developers.google.com/maps/documentation/javascript/adding-a-google-map#try-it-yourself
