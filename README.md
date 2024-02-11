
# Test Assignment

### [test-assignment-nginx.fly.dev](https://test-assignment-nginx.fly.dev/)
### [github.com](https://github.com/artemexex3000)

<p>Please, provide me your username in github via email mrtrololoshka70@gmail.com before code-review, because code placed into private repository.</p> 

## 1. Used packages and tools

### 1.1 Composer

- #### league/flysystem-aws-s3-v3: 3.24
- #### tinify/tinify: 1.6

### 1.2 NPM

- #### tailwindcss: 3.4.1
- #### daisyui: 4.6.0

### 1.3 Docker

#### Inner docker components:

- ##### nginx
- ##### PHP-FPM

### 1.4 fly.io

## 2. About completed tasks

<p>All tasks have been completed successfully, except, creating offset in pagination section, because of misunderstanding
how to use it at API stage.</p>
<p>Test assignment was done within about ~24 hours. It took so much time because of specific deploying into Fly.io, as hosting
that has 3 free virtual machines. In my case I have nginx server, PHP-FPM needed to interpreting php code, nginx cannot, front-end and PostgreSQL.
All components was placed into 3 different container to have a possibility to deploy them in 3 fly's VMs. Front-end assets didn't work as needed, at the first
option, because of nginx - it couldn't accept and send from remote assets from DaisyUI and Tailwind CSS to PHP-FPM. I could create fourth docker container for assets, 
but, as I said, that fly.io has 3 free vm, 4+ has to be paid, so it was decided to move assets to nginx dockerfile into subdirectory to save 3 containers: nginx+assets, PHP-FPM+composer, PostgreSQL.
Also, I had some problems with Front-end and fetching API with Javascript from remote created laravel api. I don't like front-end unlike back-end, 
therefore, I received knowledge about this while completing the task. At the start of completing task I faced with difficulty of designing token, because I didn't think,
that I could just make it manually by generating and placing into database. And the last one problem is responses. Laravel provides a good solution, generating responses automatically, 
without adding JSON headers from developer, just using it from the box. It was very long to understand, how exactly I should send as response to fetch it in front-end.</p>
<p>TinyPNG API was used to cropping images. Images save into Google Storage and get to front-end via Storage::url().</p>

