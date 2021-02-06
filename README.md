# Module Template
![Tests](https://github.com/lotgd/module-project/workflows/Tests/badge.svg)

This is a template for a new lotgd module. You can use this package to quickly
initialize a new, empty module with basic features.

For full instructions, [see the Modules section in the core's wiki](https://github.com/lotgd/core/wiki/Modules).

## Quickstart Guide

1. Make sure you have composer available and executable.
1. Run the following command, but replace `fancymodule` with whatever module name you want:
   ```sh
   composer create-project lotgd/module-project fancymodule --repository https://raw.githubusercontent.com/lotgd/packages/master/build/packages.json -s dev
   ```

1. Change the namespace (`MyVendor\MyNamespace\`) in all files. Ideally, search and replace
for MyVendor and MyNamespace individually with an editor supporting directory-wide searches.
   
1. Search and replace the module name in all files (`lotgd/module-project`).
1. Make sure you configure your `lotgd.yml` appro
1. Test your code (by running `./t` or directly vendor/bin/phpunit).
1. Use git to track your changes. 
1. Publish your code on github or somewhere else to make it available for others. You
could also use a private repository if you want to keep the module for yourself.

## Remarks

The project template comes with a bunch of empty directories. The naming scheme is 
recommended, as it helps others feel at home in your module, but you do not need 
to adhere to this system. Delete the folders and make sure remove them from your 
git repository.

### Testing

Currently, the test runners install the module, but adding the events must be done manually by adjusting
the datasets. For each module you add, you also must provide data for module registration, events, even
templates.