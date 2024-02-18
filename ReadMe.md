# Url Shortener

## Description

This is a simple URL shortener that takes a long URL and returns a shortened version of it.

## Installation

### 1. Clone the repository

```bash
git clone 
```

### 2. Copy the .env file

Linux:

```bash
cp .env.example .env
```

Windows:

```bash
copy .env.example .env
```

### 3. Create the Docker container

```bash
docker-compose up -d --build
```

## Usage

### 1. Run the docker container

```bash
docker-compose up -d
```

### 2. Open a Api client like Postman and make a POST request to the following URL

```bash
http://localhost/api/v1/short-urls
```

With the following body

```json
{
    "url": "VALID_URL"
}
```

And a Authorization header with a valid token. All Tokens are valid for now, but they cannot contain unclosed brackets, parentheses, or braces.

```json
{
    "Authorization": "Bearer VALID_TOKEN"
}
```

## Testing

### Configuration

To run the tests, you need to create a phpunit.xml file. You can do this by copying the phpunit.xml.dist file

Linux:

```bash
cp phpunit.xml.dist phpunit.xml
```

Windows:

```bash
copy phpunit.xml.dist phpunit.xml
```

### Running the tests

To run the tests, execute the following command

```bash
./vendor/bin/phpunit
```
