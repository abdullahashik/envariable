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

## Decryption Examples
Here are two examples of ways you may want to access environment variables.

### With Crypt Facade
Here's how you can decrypt the variables if you are loading the environment variable where you are able to use the 
<code>Crypt</code> facade.

```php
use Illuminate\Support\Facades\Crypt;
...
try {
    return Crypt::decrypt(env('VAR_NAME'));
} catch(DecryptException $e) {
    ...
}
```

### Without Crypt Facade
My environment variables are often used by files within my Laravel project's <code>config</code> folder such as 
<code>config/auth.php</code> and <code>config/database.php</code>. Unfortunately the <code>Crypt</code> facade is not available
within config files so you will need to create a new <code>Encrypter</code> object.

```php
$crypt = new Illuminate\Encryption\Encryper(env('APP_KEY'));
...
'mysql' => [
   'driver'    => 'mysql',
   'host'      => $crypt->decrypt(env('DB_HOST')),
   'database'  => $crypt->decrypt(env('DB_DATABASE')),
   'username'  => $crypt->decrypt(env('DB_USERNAME')),
   'password'  => $crypt->decrypt(env('DB_PASSWORD')),
   'port'      => $crypt->decrypt(env('DB_PORT')),
   ...
```

## Warnings
* Make sure you decrypt your encrypted environment variables before using them in your application.
* This command does not check if the environment variable already exists so please check your <code>.env</code> file to ensure you 
have not created duplicate variables.
* This command encrypts data but stores it in the same file as the encryption key so it isn't a substitute for existing 
security best practises. I wrote this command because I needed to encrypt an app token in order to meet a third-party 
security requirement. Please don't assume that this command makes your data any more secure.