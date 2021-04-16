# Gelato Coding Exercise: Checkout

## Description
An implementation for a supermarket checkout that calculates the total price of a number of items.

## Dev Environment Setup

### Needed tools
1. [Install Docker](https://www.docker.com/get-started)
2. [Optional] Clone this project: `git clone https://github.com/Bukarinov/gelato_coding_exercise_checkout gelato_coding_exercise_checkout`
3. Move to the project folder: `cd gelato_coding_exercise_checkout`

### Application execution

Install all the dependencies and bring up the project with Docker executing:
```bash
./bin/run-dev
```

### Tests execution

Execute PHPUnit and Behat tests:
```bash
./bin/run-tests
```

## Project structure

```
docker // Configs for the dev env

src // Source
`-- Catalog // Module
    |-- Application // Use cases layer
    `-- Domain // Domain layer

tests // Tests
|-- Behat // Behavioral tests
|  `-- Catalog // Module
|     `-- Application // Use cases
|        `-- features // Test scenarios
`-- Unit // Unit tests
   `-- Catalog // Module
      |-- Application // Use cases tests
      `-- Domain // Entities tests
```