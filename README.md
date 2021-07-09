<p align="center"><a href="https://laravel.com" target="_blank"><img alt="logo" src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Project installation

### Prerequisites
* [Composer](https://getcomposer.org/download/)
* [Docker](https://docs.docker.com/engine/install/)

### Installation
```shell
git clone https://github.com/xorth/image-uploader-rxflodev.git
cd image-uploader-rxflodev
composer install
cp .env.example .env
./vendor/bin/sail artisan key:generate
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
./vendor/bin/sail up
```
If you want to start the container in a detached mode:
```shell
./vendor/bin/sail up -d
```
After installation and starting the container you can visit the project entering [http://localhost](http://localhost) on your browser.

### Running tests
```shell
./vendor/bin/sail test
```

## Backend Test (Laravel)

### Upload and Display Images

Your task is to create a web page that allows users to upload images and then display them to the user. However, because space is limited on your web server you will need to store the images in a remote image hosting service. The end-point for the service is:
```
https://test.rxflodev.com
```
The image must be base64 encoded and posted to the end-point in the following format:
```
imageData=base64-encoded-image-data
```
After receiving an image successfully the image service will return a json encoded result in the following format:
```json
{
    "status": "success",
    "message": "Image saved successfully.",
    "url": "https://test.rxflodev.com/image-store/55c4d2369010c.png"
}
```
The image must then be displayed on the web page using the url from the result.

### Requirements and Specifications 
* Create an API endpoint on the backend to transfer the image to storage service.
* Images must be stored in the remote image service, not on your web server.
* The most recent image should be displayed first.
* Images must be in png format.
* For simplicity, you may use the session for long term storage.

## Frontend Test

### Upload and Display Images

Your task is to create a web page that allows users to upload images and then display them to the user. You will be uploading the images to a remote image hosting service. The end-point for the service is:
```
https://test.rxflodev.com/uploads/index.php
```
After receiving an image successfully the image service will return a json encoded result in the following format:
```json
{
    "status": "success",
    "message": "Image saved successfully.",
    "url": "https://test.rxflodev.com/uploads/images/55c4d2369010c.png"
}
```
The image must then be displayed on the web page using the url from the result.

### Requirements and Specifications
* The most recent uploaded image should be displayed first.
* Uploaded images must be in png format.
* The user should be able to upload multiple images.
* A pure ajax solution is preferred (ie no page refresh).
* Progress bar and other user feedback such as error / success feedback are a plus.

## Additional requirements
* Given the project that you have already done, implement the layout for uploading multiple images using react components, you can use a React dropzone 3rd party library to give the user a good way to upload more than one image at a time.
* Don't create a React project separately, instead, install react in your laravel project, and compile your js and css assets using webpack or a bundler of your preference.
* Send the data asynchronously (either using axios, fetch, ajax, etc.) to the Laravel route you already have for posting data (make any changes if needed). After the upload is successful, images should be shown without the need of refreshing the page.
* Finally, add the feature to delete images, images should be taken out of the layout without the need to refresh the page but if someone refreshes the page the images shouldn't be shown either.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
