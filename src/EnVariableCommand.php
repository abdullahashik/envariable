<?php namespace BaglerIT\EnVariableCommand;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class EnVariableEncrypt
 * @package Qbot\Console\Commands
 */
class EnVariableCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'envariable:encrypt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an encrypted variable to the .env file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        // Get the Name and Value of the environment variable.
        $name = $this->argument('name');
        $value = $this->argument('value');

        // If the name of the environment variable has not been included, ask the user for it.
        if(empty($name)) {
            $name = $this->ask('What is the name of the environment variable?');
        }

        // If the value of the environment variable has not been included, ask the user for it.
        if(empty($value)) {
            $value = $this->ask('What is the value of the environment variable?');
        }

        // Append the new environment variable to the file.
        try {
            \File::get('.env');

            // Encrypt the value.
            $encrypted_value = Crypt::encrypt($value);

            // Append the value to the .env file.
            \File::append('.env', "\n$name = $encrypted_value ");

            // Display success message using the decrypted value of the encrypted value.
            $this->info(
                'The environment variable named '
                . $name
                . ' has been added with the value of '
                . Crypt::decrypt($encrypted_value)
                . '. Please check that the value displayed is the supplied value.'
            );

        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            $this->error('Unable to load the .env file.');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the environment variable.'],
            ['value', InputArgument::OPTIONAL, 'The value of the environment variable.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
