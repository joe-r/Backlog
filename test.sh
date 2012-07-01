#!/bin/bash
./reset.sh
phpunit -c app/
bin/behat -f journal app/features > test.html
exit $?
