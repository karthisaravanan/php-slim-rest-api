<div align="center">
	<h1> PHP Slim REST Api</h1>
</div>

<div align="center">
	<a href="#changelog">
		<img src="https://img.shields.io/badge/stability-stable-green.svg" alt="Status">
	</a>
	<a href="#changelog">
		<img src="https://img.shields.io/badge/release-v1.0.0.7-blue.svg" alt="Version">
	</a>
	<a href="#changelog">
		<img src="https://img.shields.io/badge/update-january-yellowgreen.svg" alt="Update">
	</a>
	<a href="#license">
		<img src="https://img.shields.io/badge/license-MIT%20License-green.svg" alt="License">
	</a>
</div>

This is a simple REST Web Service which allow:

  * Post short text messages of no more than 120 characters
  * Bring a list with the latest published messages
  * Search for messages by your text
  * Delete a specific message by its id

<a name="started"></a>
## :traffic_light: Getting Started

This page will help you get started with this API.

<a name="requirements"></a>
### Requirements

  * PHP 5.6
  * MySQL
  * Apache Server

<a name="installation"></a>
### Installation

#### Copy this project

  1. Clone or Download this repository
  2. Unzip the archive if needed
  3. Copy the folder in the htdocs dir
  4. Start a Text Editor (Atom, Sublime, Visual Studio Code, Vim, etc)
  5. Add the project folder to the editor

#### Install the project

  1. Go to htdocs dir

  * Windows

```bash
$ cd /d C:\xampp\htdocs
```

  * Linux

```bash
$ cd /opt/lampp/htdocs
```

  * MAC

```bash
$ cd applications/mamp/htdocs
```

  2. Go to the project folder

```bash
$ cd php-slim-rest-api
```

  3. Install with composer

```bash
$ composer install
```

  Or

```bash
$ sudo php composer.phar install
```

#### Configure the project

  Copy the `.env.example` file and call it `.env`.

  Change the database configuration in the new file.

<a name="deployment"></a>
## :package: Deployment

### You may quickly test this using the built-in PHP server:
```bash
$ php -S localhost:8000
```

### Routes

  * `get` => `/authorize` - This method is used for testing the api. e.g.:

    > uri = `/public/api/v1/authorize`

<a name="license"></a>
## :memo: License

This API is licensed under the MIT License - see the
 [MIT License](https://opensource.org/licenses/MIT) for details.
