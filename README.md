# EnVariable
Add an Artisan command, <code>envariable:encrypt</code>, which adds an encrypted environement variable to the <code>.env</code> file.

## Laravel version
This tool was developed and tested using Laravel <code>5.0</code>.

## Installation
1. Require this package in your Laravel project:

```bash
composer require baglerit/envariable
```

2. Add a line in <code>app/Console/Kernel.php</code> to register this command:

```php
protected $commands = [   
    ...   
    \BaglerIT\EnVariableCommand\EnVariableCommand::class,   
];
```

## Usage Examples


### With Crypt Facade


### Without Crypt Facade

## Warnings
* Make sure you decrypt your encrypted environment variables before using them in your application.
* This command does not check if the environment variable already exists so please check your .env file to ensure you 
have not created duplicate variables.
* This command encrypts data but stores it in the same file as the encryption key so it isn't a substitute for existing 
security best practises. I wrote this command because I needed to encrypt an app token in order to meet a third-party 
security requirement. Please don't assume that this command makes your data any more secure.