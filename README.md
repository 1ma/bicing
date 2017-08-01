# Bicing

See Bicing stations occupancy levels over time.

![screenshot]


## Development

### Requirements

* [Docker Engine] >= 1.10
* [Docker Compose] >= 1.8
* [Composer] >= 1.0


### Setting Up

* Run `composer up` inside the project directory.
* In your `/etc/hosts` file, map `bicing.local` to either `localhost` or your docker-machine's IP, depending on your Docker setup.
* Visit `https://bicing.local` on your browser. The HTTPS warning is expected as the development webserver uses a self-signed certificate.


[screenshot]: http://i.imgur.com/7JzkYpD.png
[composer]: https://getcomposer.org/
[Docker Engine]: https://docs.docker.com/engine/installation/linux/docker-ce/ubuntu/
[Docker Compose]: https://github.com/docker/compose/releases
