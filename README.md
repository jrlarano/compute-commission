# compute-commission

### Run composer install for dependencies
```sh
composer install
```

### Sample command usage
```sh
$ ./console.php compute-commission input.csv
```

### CSV file should be located at
```sh
public/csv/
```

### Command name
```sh
$ ./console.php compute-commission
```

### Argument
```sh
filename with extension '.csv'
```

### For more info in command
```sh
$ ./console.php compute-commission --help
```

### Basic unit testing Command
```sh
./vendor/bin/simple-phpunit --bootstrap vendor/autoload.php tests
```

### Scope and Limitations
- Currency conversion is not supported yet.